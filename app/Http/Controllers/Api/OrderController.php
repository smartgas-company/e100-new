<?php

namespace App\Http\Controllers\Api;

use App\Helpers\E100Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateRequest;
use App\Services\CrmOrderItemDetail\CrmOrderItemDetailCommandService;
use App\Services\CrmOrderNipl\CrmOrderNiplCommandService;
use App\Services\CrmProduct\CrmProductQueryService;
use App\Services\CrmPump\CrmPumpQueryService;
use App\Services\CrmStore\CrmStoreQueryService;
use App\Services\CrmStoreProduct\CrmStoreProductQueryService;
use App\Services\CrmVirtualCart\CrmVirtualCartCommandService;
use App\Services\CrmVirtualCart\CrmVirtualCartQueryService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class OrderController extends Controller
{
    public function __construct(
        private readonly CrmStoreQueryService $crmStoreQueryService,
        private readonly CrmPumpQueryService $crmPumpQueryService,
        private readonly CrmStoreProductQueryService $crmStoreProductQueryService,
        private readonly CrmProductQueryService $crmProductQueryService,
        private readonly CrmVirtualCartQueryService $crmVirtualCartQueryService,
        private readonly CrmVirtualCartCommandService $crmVirtualCartCommandService,
        private readonly CrmOrderNiplCommandService $crmOrderNiplCommandService,
        private readonly CrmOrderItemDetailCommandService $crmOrderItemDetailCommandService,
        private readonly E100Helper $e100Helper,
    ) {
    }

    /**
     * @throws ValidationException
     * @throws GuzzleException
     */
    public function create(CreateRequest $createRequest): JsonResponse
    {
        $data = $createRequest->checked();
        $crmStore = $this->crmStoreQueryService->first([
            'id' => $data['stationId']
        ]);
        if (!$crmStore) {
            return response()->json([
                'status' => 0,
                'error'  => 'Такого АЗС не существует в бд.'
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
        $crmPump = $this->crmPumpQueryService->first([
            'title'    => $data['pumpNumber'],
            'store_id' => $crmStore->id
        ]);
        if (!$crmPump) {
            return response()->json([
                'status' => 0,
                'error'  => 'Такого АЗС или колонки в нем не существует в бд.'
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
        $crmStoreProduct = $this->crmStoreProductQueryService->first([
            'store_id'   => $crmStore->id,
            'product_id' => $data['productId']
        ]);
        if (!$crmStoreProduct) {
            return response()->json([
                'status' => 0,
                'error'  => $data['productId']
                    . ' Такого АЗС или продукта в нем не существует в бд.'
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }
        $crmProduct = $this->crmProductQueryService->first([
            'id' => $crmStoreProduct->product_id
        ]);
        $crmVirtualCart = $this->crmVirtualCartQueryService->first([
            'is_used' => 0
        ]);
        if (!$crmVirtualCart) {
            $this->crmVirtualCartCommandService->updateAll([
                'is_used' => 0
            ]);
        }
        if ($crmStore->owner_id === 9684) {
            $cardId = config('e100.helios_corp_client_card');
        } else {
            $cardId = $crmVirtualCart->guid;
            $crmVirtualCart->update(['is_used' => 1]);
        }
        $response = [
            "partnerRefuelingId" => Uuid::uuid4()->toString(),
            "stationId"          => $crmStore->wifi_name,
            "pumpNumber"         => $crmPump->title,
            "refuelProductId"    => $crmProduct->item_code,
            "paymentMethod"      => [
                "paymentSystem" => config('e100.payment_system'),
                "id"            => $cardId
            ],
            "amount"             => [
                "currency" => $crmStore->price_currency,
                "amount"   => $data['amount']
            ],
            "price"              => [
                "currency" => $crmStore->price_currency,
                "amount"   => $crmStoreProduct->price
            ]
        ];


        $crmOrderNipl = $this->crmOrderNiplCommandService->create([
            'title'              => $response['partnerRefuelingId'],
            'product_id'         => $crmStoreProduct->id,
            'store_id'           => $crmStore->id,
            'total_order_amt'    => $data['amount'],
            'store_owner_id'     => $crmStore->owner_id,
            'demand_quantity'    => $data['amount'] / $crmStoreProduct->price,
            'product_price'      => $crmStoreProduct->price,
            'pump_number'        => $crmPump->title,
            'currency'           => $crmStore->price_currency,
            'order_payment_type' => $data['paymentType'],
            'external_id'        => (!empty($data['extOrderId']))
                ? $data['extOrderId'] : 0,
            'user_id'            => (!empty($data['user_id']))
                ? $data['user_id'] : 0,
            'money_balance_id'   => (!empty($data['money_balance_id']))
                ? $data['money_balance_id'] : 0
        ]);

        $this->crmOrderItemDetailCommandService->create([
            'order_nipl_id' => $crmOrderNipl->id,
            'product_id'    => $crmOrderNipl->product_id,
            'amt'           => $data['amount'],
            'quantity'      => $data['amount'] / $crmStoreProduct->price,
        ]);

        $token = $this->e100Helper->token();

        if (!$token) {
            return response()->json([
                'status' => 0,
                'error'  => 'Failed to authenticate'
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        try {
            $response = $this->e100Helper->order($token, $response);
            if ($response->getStatusCode() !== 202) {
                $this->crmOrderNiplCommandService->update($crmOrderNipl, [
                    'status' => 4
                ]);
            }
        } catch (ClientException $exception) {
            Log::info('Create order:' . $exception->getMessage());
            Log::info('Create order:', $exception->getTrace());

            $this->crmOrderNiplCommandService->update($crmOrderNipl, [
                'status' => 4
            ]);
            $this->crmVirtualCartCommandService->update($crmVirtualCart, [
                'is_used' => 0
            ]);

            return response()->json([
                'status'      => 0,
                'description' => 'Failed to create order: '
                    . $exception->getMessage()
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'status'             => 1,
            'order_id'           => $crmOrderNipl->id,
            'partnerRefuelingId' => $response['partnerRefuelingId']
        ], ResponseAlias::HTTP_OK);
    }




}

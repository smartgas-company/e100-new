<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    public function rules(): array
    {
        return [
            'stationId'   => 'required',
            'productId'   => 'required',
            'pumpNumber'  => 'required',
            'paymentType' => 'required',
            'amount'      => 'required'
        ];
    }
}

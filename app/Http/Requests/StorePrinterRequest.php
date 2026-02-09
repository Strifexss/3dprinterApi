<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class StorePrinterRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
        ];
    }
}

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
            'model' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'technology' => 'nullable|in:FDM,SLA,DLP,SLS,MSLA,FGF,POLYJET,DMLS,BINDERJET,OUTRAS',
            'acquisition_date' => 'nullable|date',
            'warranty_until' => 'nullable|date',
            'status' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}

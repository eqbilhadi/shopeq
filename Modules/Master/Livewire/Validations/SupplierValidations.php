<?php

namespace Modules\Master\Livewire\Validations;

use Illuminate\Validation\Rule;

trait SupplierValidations
{
    protected array $validationAttributes = [
        'form.name' => 'supplier name',
        'form.phone' => 'phone number',
        'form.address' => 'address',
    ];

    protected function rules(): array
    {
        return [
            'form.name' => 'required',
            'form.phone' => 'required|numeric',
            'form.address' => 'required',
        ];
    }
}

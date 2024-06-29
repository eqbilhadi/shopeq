<?php

namespace Modules\Master\Livewire\Validations;

trait ProductUpdateValidations
{
    protected array $validationAttributes = [
        'form.name' => 'product name',
        'form.category_id' => 'product category',
        'form.description' => 'description',
        'form.barcode' => 'barcode',
        'form.minimal_stok' => 'minimal stok product',
        'form.status' => 'product status',
        'form.visibility' => 'product visibility',
        'form.images.main_image.filename' => 'main product image',
        'form.other_image' => 'other product image',
        'form.units.main_unit.unit_id' => 'main unit product',
        'form.units.main_unit.purchase_price' => 'main unit purchase price',
        'form.units.main_unit.selling_price' => 'main unit purchase price',
        'form.units.other_unit.*.unit_id' => 'other unit',
        'form.units.other_unit.*.convert_main' => 'main conversion',
        'form.units.other_unit.*.convert_other' => 'other conversion',
        'form.units.other_unit.*.purchase_price' => 'other unit purchase price',
        'form.units.other_unit.*.selling_price' => 'other unit selling price',
    ];

    protected function rules(): array
    {
        return [
            'form.name' => 'required|string',
            'form.category_id' => 'required|string',
            'form.description' => 'nullable',
            'form.barcode' => ($this->form['is_auto_barcode']) ? 'nullable' : 'required',
            'form.minimal_stok' => 'nullable|numeric',
            'form.status' => 'required',
            'form.visibility' => 'required',
            'form.images.main_image.filename' => ($this->form['images']['main_image']['filename'] instanceof \Illuminate\Http\UploadedFile) ? 'image' : 'required',
            'form.other_image' => 'nullable|image',
            'form.units.main_unit.unit_id' => 'required',
            'form.units.main_unit.purchase_price' => 'required',
            'form.units.main_unit.selling_price' => 'required',
            'form.units.other_unit.*.unit_id' => 'required',
            'form.units.other_unit.*.convert_main' => 'required',
            'form.units.other_unit.*.convert_other' => 'required',
            'form.units.other_unit.*.purchase_price' => 'required',
            'form.units.other_unit.*.selling_price' => 'required',
        ];
    }
}

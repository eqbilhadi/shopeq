<?php

namespace Modules\Master\Services\Product\Action;

use Illuminate\Support\Arr;
use Modules\Master\app\Models\MstProduct;

class InsertProduct
{
    protected MstProduct $product;

    protected array $data = [];
    protected array $images = [];
    protected array $units = [];

    /**
     * Method __construct
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;

        $this->images = $data['images'];

        $this->units = $data['units'];
    }

    /**
     * Method handle
     *
     * @return void
     */
    public function handle(): static
    {
        $this->product = MstProduct::create($this->getRegistrationDataProduct());

        $this->product->images()->createMany($this->getRegistrationDataProductImage());
        $this->product->units()->createMany($this->getRegistrationDataProductUnits());

        return $this;
    }

    /**
     * Get register data
     *
     * @return array
     */
    protected function getRegistrationDataProduct(): array
    {
        // set data
        $data = [
            'category_id' => Arr::get($this->data, 'category_id'),
            'name' => Arr::get($this->data, 'name'),
            'description' => Arr::get($this->data, 'description'),
            'barcode' => ($this->data['is_auto_barcode']) ? MstProduct::generateAutomaticBarcode() : Arr::get($this->data, 'barcode'),
            'minimal_stok' => Arr::get($this->data, 'minimal_stok'),
            'status' => Arr::get($this->data, 'status'),
            'visibility' => Arr::get($this->data, 'visibility'),
        ];

        return $data;
    }

    protected function getRegistrationDataProductImage(): array
    {
        // Main Image Product
        $filename = $this->images['main_image']['filename']->store('images/product-img', 'public_upload');
        $images = [
            [
                'filename' => $filename,
                'is_main_image' => true
            ]
        ];

        // Other Image Product
        foreach ($this->images['other_image'] as $key => $other_image) {
            $filename = $other_image->store('images/product-img', 'public_upload');

            $images[] = [
                'filename' => $filename,
                'is_main_image' => false
            ];
        }

        return $images;
    }

    public function getRegistrationDataProductUnits(): array
    {
        // Main Unit Product
        $units = [
            [
                'unit_id' => $this->units['main_unit']['unit_id'],
                'selling_price' => preg_replace("/[^0-9]/", "", $this->units['main_unit']['selling_price']),
                'purchase_price' => preg_replace("/[^0-9]/", "", $this->units['main_unit']['purchase_price']),
                'is_main_unit' => true
            ]
        ];

        // Other Unit Product
        foreach ($this->units['other_unit'] as $key => $other_unit) {
            $units[] = [
                'unit_id' => $other_unit['unit_id'],
                'convert_main' => $other_unit['convert_main'],
                'convert_other' => $other_unit['convert_other'],
                'selling_price' => preg_replace("/[^0-9]/", "", $other_unit['selling_price']),
                'purchase_price' => preg_replace("/[^0-9]/", "", $other_unit['purchase_price']),
                'is_main_unit' => false
            ];
        }

        return $units;
    }
}

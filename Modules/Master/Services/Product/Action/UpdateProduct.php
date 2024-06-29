<?php

namespace Modules\Master\Services\Product\Action;

use Illuminate\Support\Arr;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\Services\Product\DestroyFileProduct;

class UpdateProduct
{

    protected array $data = [];

    protected array $images = [];

    protected array $units = [];

    protected ?MstProduct $product = null;

    /**
     * Method __construct
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function __construct(?MstProduct $product = null, array $data = [])
    {
        $this->data = $data;

        $this->product = $product;

        $this->product->load(['images', 'units']);

        $this->images = $data['images'];

        $this->units = $data['units'];
    }

    /**
     * Method create
     *
     * @return static
     */
    public function handle(): static
    {
        // Handle Product
        $this->product->update($this->getRegistrationDataProduct());

        // Handle Image Product
        $this->handleImageProduct();

        // Handle Unit Product
        $this->handleUnitProduct();

        return $this;
    }

    /**
     * Method handleImageProduct
     *
     * @return void
     */
    protected function handleImageProduct(): void
    {
        $validIdsImages = [];
        foreach ($this->getRegistrationDataProductImage() as $key => $image) {
            if (!is_null($image['id'])) {
                $this->product->images->where('id', $image['id'])->first()->update($image);
            } else {
                $this->product->images()->create($image);
            }

            array_push($validIdsImages, $image['id']);
        }

        $deletedImage = $this->product->images->whereNotIn('id', $validIdsImages);
        $deletedImage->each(function ($img) {
            // delete on database
            DestroyFileProduct::destroyByPath($img->filename);
            // delete on file
            $img->delete();
        });
    }

    /**
     * Method handleUnitProduct
     *
     * @return void
     */
    protected function handleUnitProduct(): void
    {
        $validIdsUnits = [];
        foreach ($this->getRegistrationDataProductUnits() as $key => $unit) {
            if (!is_null($unit['id'])) {
                $this->product->units->where('id', $unit['id'])->first()->update($unit);
            } else {
                $this->product->units()->create($unit);
            }

            array_push($validIdsUnits, $unit['id']);
        }

        $deletedUnit = $this->product->units->whereNotIn('id', $validIdsUnits);
        $deletedUnit->each(function ($unit) {
            $unit->delete();
        });
    }

    /**
     * Method getRegistrationDataProduct
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

    /**
     * Method getRegistrationDataProductImage
     *
     * @return array
     */
    protected function getRegistrationDataProductImage(): array
    {
        // Main Image Product
        if ($this->images['main_image']['filename'] instanceof \Illuminate\Http\UploadedFile) {
            $filename = $this->images['main_image']['filename']->store('images/product-img', 'public_upload');
            DestroyFileProduct::destroyById($this->images['main_image']['id']);
        } else {
            $filename = $this->images['main_image']['filename'];
        }

        $images = [
            [
                'filename' => $filename,
                'is_main_image' => true,
                'id' => $this->images['main_image']['id'],
                'imageable_id' => $this->images['main_image']['imageable_id'],
            ]
        ];

        // Other Image Product
        foreach ($this->images['other_image'] as $key => $other_image) {
            if ($other_image['filename'] instanceof \Illuminate\Http\UploadedFile) {
                $filename = $other_image['filename']->store('images/product-img', 'public_upload');
                DestroyFileProduct::destroyById($other_image['id']);
            } else {
                $filename = $other_image['filename'];
            }


            $images[] = [
                'filename' => $filename,
                'is_main_image' => false,
                'id' => $other_image['id'],
                'imageable_id' => $other_image['imageable_id'],
            ];
        }

        return $images;
    }

    /**
     * Method getRegistrationDataProductUnits
     *
     * @return array
     */
    public function getRegistrationDataProductUnits(): array
    {
        // Main Unit Product
        $units = [
            [
                'id' => $this->units['main_unit']['id'],
                'unit_id' => $this->units['main_unit']['unit_id'],
                'selling_price' => preg_replace("/[^0-9]/", "", $this->units['main_unit']['selling_price']),
                'purchase_price' => preg_replace("/[^0-9]/", "", $this->units['main_unit']['purchase_price']),
                'is_main_unit' => true
            ]
        ];

        // Other Unit Product
        foreach ($this->units['other_unit'] as $key => $other_unit) {
            $units[] = [
                'id' => $other_unit['id'],
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

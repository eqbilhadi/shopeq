<?php

namespace Modules\Master\Livewire\Product\Form;

use Exception;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Modules\Master\Services\ProductService;

class ProductEditForm extends Form
{
    use WithFileUploads;

    #[Validate('nullable|image')]
    public $images;

    #[Validate('nullable|image')]
    public $mainImages;

    #[Validate('required|string')]
    public $name;

    #[Validate('required')]
    public $sellingPrice;

    #[Validate('required')]
    public $purchasePrice;

    #[Validate('required', as: 'category')]
    public $categoryId = "";

    #[Validate('required', as: 'main unit')]
    public $mainUnitId = "";

    #[Validate('required')]
    public $status = "";

    #[Validate('required')]
    public $visibility = "";

    #[Validate(['unitId.*' => 'required'], attribute: ['unitId.*' => 'other unit'])]
    public array $unitId = [];

    #[Validate(['convertMain.*' => 'required'], attribute: ['convertMain.*' => 'main conversion'])]
    public array $convertMain = [];

    #[Validate(['convertOther.*' => 'required'], attribute: ['convertOther.*' => 'other conversion'])]
    public array $convertOther = [];

    #[Validate(['editUnitId.*' => 'required'], attribute: ['editUnitId.*' => 'other unit'])]
    public array $editUnitId = [];

    #[Validate(['editConvertMain.*' => 'required'], attribute: ['editConvertMain.*' => 'main conversion'])]
    public array $editConvertMain = [];

    #[Validate(['editConvertOther.*' => 'required'], attribute: ['editConvertOther.*' => 'other conversion'])]
    public array $editConvertOther = [];

    public array $editIdUnitId = [];

    public $minimalStok;
    public $description;
    public $barcode;

    public $iteration = 0;
    public bool $isAutoBarcode = true;
    public array $stageImages = [];

    public $previewMainImage;
    public $idMainImage;
    public array $previewStageImages = [];

    public $compareMainUnitId;

    public $products;

    protected $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function setProduct($product)
    {
        // Product
        $this->products = $product;
        $this->name = $product->name;
        $this->sellingPrice = number_format($product->selling_price, 0, '.', '.');
        $this->purchasePrice = number_format($product->purchase_price, 0, '.', '.');
        $this->categoryId = $product->category_id;
        $this->status = $product->status;
        $this->visibility = $product->visibility;
        $this->minimalStok = $product->minimal_stok;
        $this->description = $product->description;
        $this->barcode = $product->barcode;

        // Image Product
        $this->previewMainImage = $product->images()->whereIsMainImage(true)->first()->img_url ?? null;
        $this->idMainImage = $product->images()->whereIsMainImage(true)->first()->id ?? null;
        $subImages = $product->images()->whereIsMainImage(false)->get();
        foreach ($subImages as $value) {
            array_push($this->previewStageImages, ["src" => $value->img_url, "filename" => $value->filename, "idImage" => $value->id]);
        }

        // Unit Product
        $this->mainUnitId = $product->units()->whereIsMainUnit(true)->first()->unit_id ?? null;
        $this->compareMainUnitId = $product->units()->whereIsMainUnit(true)->first()->unit_id ?? null;
        $subUnit = $product->units()->whereIsMainUnit(false)->get();
        foreach ($subUnit as $value) {
            array_push($this->editIdUnitId, $value->id);
            array_push($this->editUnitId, $value->unit_id);
            array_push($this->editConvertMain, $value->convert_main);
            array_push($this->editConvertOther, $value->convert_other);
        }
    }

    public function updatedImages($value)
    {
        $this->validateOnly('images');
        array_push($this->stageImages, $value);
        $this->iteration++;
        $this->reset('images');
    }

    public function update()
    {
        $this->editUnit();
        $this->validate();

        $paramsImages = $this->storeImage();
        $paramsUnit = $this->storeUnit();
        $paramsEditUnit = $this->editUnit();
        $form = array_merge($this->all(), ['paramsImages' => $paramsImages], ['paramsUnit' => $paramsUnit], ['paramsEditUnit' => $paramsEditUnit]);

        try {
            $this->productService->update($form);
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');

            return to_route('master.product.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to save');
        }
    }

    public function storeImage()
    {
        $paramsImages = [];

        if (!empty($this->mainImages)) {
            $this->productService->deleteImageProduct($this->idMainImage);

            $filename = $this->mainImages->store('images/product-img', 'public_upload');

            $paramsImages[] = [
                'filename' => $filename,
                'is_main_image' => true
            ];
        }

        if (!empty($this->stageImages)) {
            foreach ($this->stageImages as $key => $value) {
                $filename = $value->store('images/product-img', 'public_upload');

                $paramsImages[] = [
                    'filename' => $filename,
                    'is_main_image' => false
                ];
            }
        }

        return $paramsImages;
    }

    public function storeUnit()
    {
        $paramsUnit = [];

        if ($this->compareMainUnitId != $this->mainUnitId) {
            $paramsUnit[] = [
                'unit_id' => $this->mainUnitId,
                'is_main_unit' => true
            ];
        }

        if (!empty($this->unitId)) {
            foreach ($this->unitId as $key => $value) {
                $paramsUnit[] = [
                    'unit_id' => $value,
                    'convert_main' => $this->convertMain[$key],
                    'convert_other' => $this->convertOther[$key],
                    'is_main_unit' => false
                ];
            }
        }

        return $paramsUnit;
    }

    public function editUnit()
    {
        $subUnit = [];

        if(!empty($this->editUnitId)) {
            foreach ($this->editUnitId as $key => $value) {
                $subUnit[] = [
                    'id' => $this->editIdUnitId[$key],
                    'unit_id' => $value,
                    'convert_main' => $this->editConvertMain[$key],
                    'convert_other' => $this->editConvertOther[$key],
                    'is_main_unit' => false
                ];
            }
        }

        return $subUnit;
    }

    public function deleteSubImage($id)
    {
        try {
            $this->productService->deleteImageProduct($id);
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Image deleted successfully');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Image failed to delete');
        }
    }

    public function deleteSubUnit($id)
    {
        $this->productService->deleteUnitProduct($id);
    }
}

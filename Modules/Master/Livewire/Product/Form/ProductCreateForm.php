<?php

namespace Modules\Master\Livewire\Product\Form;

use Exception;
use Illuminate\Support\Arr;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Modules\Master\Services\ProductService;

class ProductCreateForm extends Form
{
    use WithFileUploads;

    #[Validate('nullable|image')]
    public $images;

    #[Validate('required|image')]
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

    #[Validate(
        [
            'unitId.*' => 'required'
        ],
        attribute: [
            'unitId.*' => 'other unit',
        ]
    )]
    public array $unitId = [];
    
    #[Validate(
        [
            'convertMain.*' => 'required'
        ],
        attribute: [
            'convertMain.*' => 'main conversion',
        ]
    )]
    public array $convertMain = [];
    
    #[Validate(
        [
            'convertOther.*' => 'required'
        ],
        attribute: [
            'convertOther.*' => 'other conversion',
        ]
    )]
    public array $convertOther = [];
    
    public $minimalStok;
    public $description;
    public $barcode;

    public $iteration = 0;
    public bool $isAutoBarcode = true;
    public array $stageImages = [];

    protected $productService;

    public function boot(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function updatedImages($value)
    {
        $this->validateOnly('images');
        array_push($this->stageImages, $value);
        $this->iteration++;
        $this->reset('images');
    }

    public function store()
    {
        $this->validate();

        $paramsImages = $this->storeImage();
        $paramsUnit = $this->storeUnit();
        $form = array_merge($this->all(), ['paramsImages' => $paramsImages], ['paramsUnit' => $paramsUnit]);

        $this->productService->store($form);
        try {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data saved successfully');

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
        $filename = $this->mainImages->store('images/product-img', 'public_upload');
        $paramsImages[] = [
            'filename' => $filename,
            'is_main_image' => true
        ];

        foreach ($this->stageImages as $key => $value) {
            $filename = $value->store('images/product-img', 'public_upload');

            $paramsImages[] = [
                'filename' => $filename,
                'is_main_image' => false
            ];
        }

        return $paramsImages;
    }

    public function storeUnit()
    {
        $paramsUnit[] = [
            'unit_id' => $this->mainUnitId,
            'is_main_unit' => true
        ];

        foreach ($this->unitId as $key => $value) {
            $paramsUnit[] = [
                'unit_id' => $value,
                'convert_main' => $this->convertMain[$key],
                'convert_other' => $this->convertOther[$key],
                'is_main_unit' => false
            ];
        }

        return $paramsUnit;
    }
}

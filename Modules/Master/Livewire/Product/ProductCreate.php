<?php

namespace Modules\Master\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Master\Livewire\Product\Form\ProductCreateForm;
use Modules\Master\Services\CategoryService;
use Modules\Master\Services\UnitService;

class ProductCreate extends Component
{
    use WithFileUploads;

    public ProductCreateForm $form;

    protected $categoryService;
    protected $unitService;

    public array $inputSubUnit = [];

    public function boot(
        CategoryService $categoryService,
        UnitService $unitService
    ) {
        $this->categoryService = $categoryService;
        $this->unitService = $unitService;
    }

    public function updatedFormImages($value)
    {
        $this->form->updatedImages($value);
    }

    public function deleteTemporaryImg($key)
    {
        unset($this->form->stageImages[$key]);
    }

    public function addSubUnit()
    {
        array_push($this->inputSubUnit, "-");
        array_push($this->form->unitId, "");
        array_push($this->form->convertMain, "");
        array_push($this->form->convertOther, "");
    }
    
    public function removeSubUnit($key)
    {
        unset($this->inputSubUnit[$key]);
        unset($this->form->unitId[$key]);
        unset($this->form->convertMain[$key]);
        unset($this->form->convertOther[$key]);
    }

    public function save()
    {
        $this->form->store();
    }

    public function render()
    {
        return view('master::livewire.product.product-create', [
            'categoryOptions' => $this->categoryService->getCategory(),
            'unitOptions' => $this->unitService->getUnit()
        ]);
    }
}

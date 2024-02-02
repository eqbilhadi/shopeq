<?php

namespace Modules\Master\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Master\Livewire\Product\Form\ProductEditForm;
use Modules\Master\Services\CategoryService;
use Modules\Master\Services\UnitService;

class ProductEdit extends Component
{
    use WithFileUploads;

    public ProductEditForm $form;

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

    public function mount($product)
    {
        $this->form->setProduct($product);
    }

    public function updatedFormImages($value)
    {
        $this->form->updatedImages($value);
    }

    public function deleteTemporaryImg($key)
    {
        unset($this->form->stageImages[$key]);
    }

    public function deleteSubImage($id, $key)
    {
        $this->form->deleteSubImage($id);
        unset($this->form->previewStageImages[$key]);
        $this->dispatch("close-modal");
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

    public function deleteSubUnit($key)
    {
        $this->form->deleteSubUnit($this->form->editIdUnitId[$key]);

        unset($this->form->editUnitId[$key]);
        unset($this->form->editConvertMain[$key]);
        unset($this->form->editConvertOther[$key]);
        unset($this->form->editIdUnitId[$key]);
    }

    public function save()
    {
        $this->form->update();
    }

    public function render()
    {
        return view('master::livewire.product.product-edit', [
            'categoryOptions' => $this->categoryService->getCategory(),
            'unitOptions' => $this->unitService->getUnit()
        ]);
    }
}

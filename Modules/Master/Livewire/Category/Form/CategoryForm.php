<?php

namespace Modules\Master\Livewire\Category\Form;

use Exception;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Modules\Master\Services\CategoryService;

class CategoryForm extends Form
{
    #[Validate('required|string')]
    public $name = null;

    public $status = true;

    public $actionForm = "add";

    public $modalTitle = "Add Category";

    public $categoryId;

    public array $idBulkDelete = [];

    protected $categoryService;

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function setForm($id)
    {
        $data = $this->categoryService->getCategoryById($id);

        $this->name = $data->name;
        $this->categoryId = $data->id;
    }

    public function store()
    {
        $this->validate();

        try {
            $this->categoryService->store($this->all());
            $this->reset('name');
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data saved successfully');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to save');
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $this->categoryService->update($this->all(), $this->categoryId);
            $this->reset('name');
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to update');
        }
    }

    public function bulkDelete()
    {
        try {
            $this->categoryService->deleteBatchCategory($this->idBulkDelete);
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess(count($this->idBulkDelete) . ' items data successfully deleted');
            $this->idBulkDelete = [];
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to deleted');
        }
    }
}

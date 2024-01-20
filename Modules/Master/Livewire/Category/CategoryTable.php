<?php

namespace Modules\Master\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Master\Services\CategoryService;
use Modules\Master\Livewire\Category\Form\CategoryForm;

class CategoryTable extends Component
{
    use WithPagination;

    public CategoryForm $form;

    protected $categoryService;

    public $filter = [
        'search' => null
    ];

    public function boot(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function openModal($action, $id)
    {
        $this->form->reset();

        $this->form->actionForm = $action;
        if ($action == "add") {
            $this->form->modalTitle = "Add Category";
        } else {
            $this->form->modalTitle = "Edit Category";
            $this->form->setForm($id);
        }

        $this->dispatch("open-modal");
    }

    public function save()
    {
        if ($this->form->actionForm == "add") {
            $this->form->store();
            $this->dispatch("close-modal");
        } else {
            $this->form->update();
            $this->dispatch("close-modal");
        }
    }

    public function delete($id)
    {
        $this->categoryService->deleteCategory($id);
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess('Data successfully deleted');
        $this->dispatch("close-modal");
    }

    public function render()
    {
        return view('master::livewire.category.category-table', [
            'results' => $this->categoryService->getPageDataCategory($this->filter)
        ]);
    }
}

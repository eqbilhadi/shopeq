<?php

namespace Modules\Master\Livewire\Unit;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Master\Services\UnitService;
use Modules\Master\Livewire\Unit\Form\UnitForm;

class UnitTable extends Component
{
    use WithPagination;

    public UnitForm $form;

    protected $unitService;

    public $filter = [
        'search' => null
    ];

    public function boot(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function openModal($action, $id)
    {
        $this->form->reset();

        $this->form->actionForm = $action;
        if ($action == "add") {
            $this->form->modalTitle = "Add Unit";
        } else {
            $this->form->modalTitle = "Edit Unit";
            $this->form->setForm($id);
        }

        $this->dispatch("open-modal");
    }

    public function changeActiveStatus($id, $is_status)
    {
        $status = !$is_status;
        $this->unitService->changeActiveStatus($id, $status);
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
        $this->unitService->deleteUnit($id);
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess('Data successfully deleted');
        $this->dispatch("close-modal");
    }

    public function bulkDelete()
    {
        $this->form->bulkDelete();
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('master::livewire.unit.unit-table', [
            'results' => $this->unitService->getPageDataUnit($this->filter)
        ]);
    }
}

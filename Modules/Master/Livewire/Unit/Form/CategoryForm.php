<?php

namespace Modules\Master\Livewire\Unit\Form;

use Exception;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Modules\Master\Services\UnitService;

class UnitForm extends Form
{
    #[Validate('required|string')]
    public $name = null;

    public $status = true;

    public $actionForm = "add";

    public $modalTitle = "Add Unit";

    public $unitId;

    public array $idBulkDelete = [];

    protected $unitService;

    public function boot(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function setForm($id)
    {
        $data = $this->unitService->getUnitById($id);

        $this->name = $data->name;
        $this->unitId = $data->id;
    }

    public function store()
    {
        $this->validate();

        try {
            $this->unitService->store($this->all());
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
            $this->unitService->update($this->all(), $this->unitId);
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
            $this->unitService->deleteBatchUnit($this->idBulkDelete);
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

<?php

namespace Modules\Master\Livewire\Supplier;

use Exception;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Master\app\Models\MstSupplier;
use Modules\Master\Livewire\Validations\SupplierValidations;
use Modules\Master\Services\Supplier\Destroy\SupplierDestroy;
use Modules\Master\Services\Supplier\Registration\SupplierRegistration;
use Modules\Master\traits\WithFlashMessage;

class SupplierTable extends Component
{
    use SupplierValidations, WithFlashMessage;

    public ?MstSupplier $supplier = null;

    public array $form = [
        'name' => '',
        'phone' => '',
        'address' => ''
    ];

    public array $filter = [
        'search' => '',
        'actionForm' => 'add',
        'modalTitle' => 'Add Supplier'
    ];

    public array $idBulkDelete = [];

    public function openModal($action, $id = null)
    {
        $this->supplier = null;
        $this->reset('form');

        $this->filter['actionForm'] = $action;
        if ($action == "add") {
            $this->filter['modalTitle'] = "Add Supplier";
        } else {
            $this->filter['modalTitle'] = "Edit Supplier";
            $this->setForm($id);
        }

        $this->dispatch("open-modal");
    }

    public function save()
    {
        $this->validate();

        try {
            (new SupplierRegistration($this->supplier, $this->form))->handle();
            
            $this->flashSuccess('Successfully saved');
            $this->dispatch("close-modal");
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    #[Computed]
    public function suppliers()
    {
        return MstSupplier::filter($this->filter)->paginate(10);
    }

    public function setForm($id)
    {
        $this->supplier = MstSupplier::find($id);

        $this->form['name'] = $this->supplier->name;
        $this->form['phone'] = $this->supplier->phone;
        $this->form['address'] = $this->supplier->address;
    }

    public function delete($id)
    {
        (new SupplierDestroy($id))->handle();

        $this->flashSuccess('Successfully deleted');
        $this->dispatch("close-modal");
    }

    public function bulkDelete()
    {
        (new SupplierDestroy($this->idBulkDelete))->handle();

        $this->flashSuccess(count($this->idBulkDelete) . ' items data successfully deleted');
        $this->idBulkDelete = [];
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('master::livewire.supplier.supplier-table', [
            'results' => $this->suppliers
        ]);
    }
}

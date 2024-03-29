<?php

namespace Modules\Master\Livewire\Customer;

use App\Models\User;
use Exception;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Master\app\Models\MstCustomer;
use Modules\Master\Livewire\Validations\CustomerValidations;
use Modules\Master\Services\Customer\Destroy\CustomerDestroy;
use Modules\Master\Services\Customer\Registration\CustomerRegistration;
use Modules\Master\traits\WithFlashMessage;

class CustomerTable extends Component
{
    use CustomerValidations, WithFlashMessage;

    public ?MstCustomer $customer = null;

    public array $form = [
        'name' => '',
        'phone' => '',
        'address' => '',
        'gender' => 'l',
        'user_id' => '',
    ];

    public array $filter = [
        'search' => '',
        'actionForm' => 'add',
        'modalTitle' => 'Add Customer'
    ];

    public array $idBulkDelete = [];

    public function openModal($action, $id = null)
    {
        $this->customer = null;
        $this->reset('form');

        $this->filter['actionForm'] = $action;
        if ($action == "add") {
            $this->filter['modalTitle'] = "Add Customer";
        } else {
            $this->filter['modalTitle'] = "Edit Customer";
            $this->setForm($id);
        }

        $this->dispatch("open-modal");
    }

    public function save()
    {
        $this->validate();

        try {
            (new CustomerRegistration($this->customer, $this->form))->handle();

            $this->flashSuccess('Successfully saved');
            $this->dispatch("close-modal");
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    #[Computed]
    public function customers()
    {
        return MstCustomer::filter($this->filter)->paginate(10);
    }

    #[Computed]
    public function userNotInCustomers()
    {
        return User::whereNotIn('id', MstCustomer::select('user_id'))->get();
    }

    public function setForm($id)
    {
        $this->customer = MstCustomer::find($id);

        $this->form['name'] = $this->customer->name;
        $this->form['phone'] = $this->customer->phone;
        $this->form['address'] = $this->customer->address;
    }

    public function getUser($id)
    {
        $user = User::find($id);

        if (!is_null($user)) {
            $this->form['name'] = $user->full_name;
            $this->form['phone'] = $user->phone;
            $this->form['address'] = $user->address;
            $this->form['gender'] = $user->gender;
            $this->form['user_id'] = $user->id;
        } else {
            $this->form['name'] = '';
            $this->form['phone'] = '';
            $this->form['address'] = '';
            $this->form['gender'] = 'l';
            $this->form['user_id'] = '';
        }
    }

    public function delete($id)
    {
        (new CustomerDestroy($id))->handle();

        $this->flashSuccess('Successfully deleted');
        $this->dispatch("close-modal");
    }

    public function bulkDelete()
    {
        (new CustomerDestroy($this->idBulkDelete))->handle();

        $this->flashSuccess(count($this->idBulkDelete) . ' items data successfully deleted');
        $this->idBulkDelete = [];
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('master::livewire.customer.customer-table', [
            'results' => $this->customers,
            'user_options' => $this->userNotInCustomers
        ]);
    }
}

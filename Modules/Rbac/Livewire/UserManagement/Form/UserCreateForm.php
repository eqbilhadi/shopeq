<?php

namespace Modules\Rbac\Livewire\UserManagement\Form;

use Exception;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Modules\Rbac\Services\UserService;

class UserCreateForm extends Form
{
    #[Validate('required|unique:users|string|min:3')]
    public $username;

    #[Validate('required|unique:users|string|email')]
    public $email;

    #[Validate('required|string|min:8')]
    public $password;

    #[Validate('required')]
    public $role = [];

    #[Validate('required')]
    public $first_name;

    #[Validate('required')]
    public $last_name;

    public $birthplace;
    public $birthdate;
    public $gender;
    public $phone;
    public $address;
    public $photo;

    protected $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store()
    {
        $this->validate();

        $filename = $this->storeImage();
        $form = array_merge($this->all(), ['avatar' => $filename]);
        $this->userService->store($form);
        try {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data saved successfully');
            return redirect()->route('rbac.user.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to save');
            return redirect()->route('rbac.user.index');
        }
    }

    public function storeImage()
    {
        if ($this->photo != null) {
            $filename = $this->photo->store('images/user-profile', 'public_upload');
            return $filename;
        } else {
            return null;
        }
    }
}

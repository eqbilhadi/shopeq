<?php

namespace Modules\Rbac\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Rbac\Services\UserService;
use Modules\Rbac\Services\RoleService;
use Modules\Rbac\Livewire\UserManagement\Form\UserCreateForm;

class UserCreate extends Component
{
    use WithFileUploads;
    
    protected $userService;
    protected $roleService;

    public UserCreateForm $form;

    public $roleOption;

    public function boot(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function mount()
    {
        $this->roleOption = $this->roleService->getRole();
    }

    public function save()
    {
        $this->form->store();
    }

    public function render()
    {
        return view('rbac::livewire.user-management.user-create');
    }
}

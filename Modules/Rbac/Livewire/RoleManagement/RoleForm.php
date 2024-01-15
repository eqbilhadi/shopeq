<?php

namespace Modules\Rbac\Livewire\RoleManagement;

use App\Jobs\ForgetCacheMenu;
use Livewire\Component;
use Modules\Rbac\Livewire\RoleManagement\Form\RolePropertyForm;
use Modules\Rbac\Services\MenuService;
use Modules\Rbac\Services\RoleService;


class RoleForm extends Component
{
    protected $menuService;
    protected $roleService;

    public $navigations;
    public $formType;

    public RolePropertyForm $form;

    public function boot(MenuService $menuService, RoleService $roleService)
    {
        $this->menuService = $menuService;
        $this->roleService = $roleService;
    }

    public function mount($formType, $role)
    {
        $this->navigations = $this->menuService->getPageDataNavigation($filter = []);

        $this->formType = $formType;

        if($role != null) {
            $this->form->setRole($role);
        }
    }

    public function updatedFormCode()
    {
        $this->form->code = strtoupper(strtolower($this->form->code));
    }

    public function save()
    {
        if($this->formType == "create") {
            $this->form->store();
        } else {
            $this->form->update();
        }
        dispatch(new ForgetCacheMenu());
    }

    public function render()
    {
        return view('rbac::livewire.role-management.role-form');
    }
}

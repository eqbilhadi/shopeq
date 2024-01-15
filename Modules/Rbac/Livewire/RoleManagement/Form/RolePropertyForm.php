<?php

namespace Modules\Rbac\Livewire\RoleManagement\Form;

use Exception;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Modules\Rbac\Services\RoleService;

class RolePropertyForm extends Form
{
    #[Validate('required')]
    public $name;
    
    #[Validate('required|max:3')]
    public $code;

    public $description;
    
    public bool $is_active = true;

    public array $menu_id = [];

    public $id;

    protected $roleService;

    public function boot(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function setRole($role)
    {
        $this->name = $role->name;
        $this->code = $role->code;
        $this->description = $role->description;
        $this->is_active = $role->is_active;
        $this->id = $role->id;

        $menus = $role->menus()->pluck('menu_id');
        foreach ($menus as $menu_id) {
            $this->menu_id[] = $menu_id;
        }
    }

    public function store()
    {
        $this->validate();

        try {
            $this->roleService->store($this->all());
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data saved successfully');
            return redirect()->route('rbac.role.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to save');
            return redirect()->route('rbac.role.index');
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $this->roleService->update($this->all());
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');
            return redirect()->route('rbac.role.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to update');
            return redirect()->route('rbac.role.index');
        }
    }
}
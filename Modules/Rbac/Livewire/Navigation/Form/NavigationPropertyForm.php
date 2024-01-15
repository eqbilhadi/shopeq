<?php

namespace Modules\Rbac\Livewire\Navigation\Form;

use Exception;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Modules\Rbac\Services\MenuService;

class NavigationPropertyForm extends Form
{
    #[Validate('required|string')]
    public $icon = null;

    #[Validate('required|string')]
    public $label_name = null;

    #[Validate('required|string')]
    public $controller_name = null;

    #[Validate('required|string')]
    public $route_name = null;

    #[Validate('required|string')]
    public $url = null;

    public $parent_id = null;
    public $is_active = false;

    public $id;

    protected $menuService;

    public function boot(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function setNavigation($menu)
    {
        $this->icon = $menu->icon;
        $this->label_name = $menu->label_name;
        $this->controller_name = $menu->controller_name;
        $this->route_name = $menu->route_name;
        $this->url = $menu->url;
        $this->parent_id = $menu->parent_id;
        $this->is_active = $menu->is_active;
        $this->id = $menu->id;
    }

    public function store()
    {
        $this->validate();

        try {
            $this->menuService->store($this->all());
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data saved successfully');
            return to_route('rbac.nav.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to save');
            return to_route('rbac.nav.index');
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $this->menuService->update($this->all());
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');
            return to_route('rbac.nav.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to update');
            return to_route('rbac.nav.index');
        }
    }
}

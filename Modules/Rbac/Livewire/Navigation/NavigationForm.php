<?php

namespace Modules\Rbac\Livewire\Navigation;

use Exception;
use Livewire\Component;
use Modules\Rbac\Services\MenuService;
use Modules\Rbac\Livewire\Navigation\Form\NavigationPropertyForm;

class NavigationForm extends Component
{
    protected $menuService;

    public $parentMenuOption;

    public $formType;

    public NavigationPropertyForm $form;

    public function boot(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function mount($formType, $menu)
    {
        $this->parentMenuOption = $this->menuService->getParentMenu();

        $this->formType = $formType;

        if($menu != null) {
            $this->form->setNavigation($menu);
        }
    }

    public function save()
    {
        if($this->formType == "create") {
            $this->form->store();
        } else {
            $this->form->update();
        }
    }

    public function render()
    {
        return view('rbac::livewire.navigation.navigation-form');
    }
}

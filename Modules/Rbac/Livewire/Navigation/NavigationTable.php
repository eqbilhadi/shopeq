<?php

namespace Modules\Rbac\Livewire\Navigation;

use Livewire\Component;
use Modules\Rbac\Services\MenuService;
use App\Jobs\ForgetCacheMenu;

class NavigationTable extends Component
{
    protected $menuService;
    public $filter = [
        'search' => null,
        'active' => null
    ];

    public array $idBulkDelete = [];

    public function boot(
        MenuService $menuService
    ) {
        $this->menuService = $menuService;
    }

    public function changeActiveStatus($id, $is_status)
    {
        $status = !$is_status;
        $this->menuService->changeActiveStatus($id, $status);
        dispatch(new ForgetCacheMenu());
    }

    public function delete($id)
    {
        $this->dispatch('close-modal');
        $this->menuService->deleteMenu($id);
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess('Data successfully deleted');

        dispatch(new ForgetCacheMenu());
    }

    public function changeOrder($id, $order)
    {
        $this->menuService->changeMenuOrder($order, $id);
        dispatch(new ForgetCacheMenu());
    }

    public function selectWithChild($val)
    {
        $childs = $this->menuService->getChildMenuWithId($val);

        foreach ($childs as $key => $child) {
            if (!in_array($child->id, $this->idBulkDelete)) {
                array_push($this->idBulkDelete, $child->id);
            }
        }
    }

    public function unSelectWithChild($val)
    {
        $childs = $this->menuService->getChildMenuWithId($val);

        foreach ($childs as $key => $child) {
            if (in_array($child->id, $this->idBulkDelete)) {
                $valueToUnset = $child->id;
                $this->idBulkDelete = array_filter($this->idBulkDelete, function ($element) use ($valueToUnset) {
                    return $element !== $valueToUnset;
                });
            }
        }
    }

    public function bulkDelete()
    {
        $this->dispatch('close-modal');
        $this->menuService->deleteBatchMenu($this->idBulkDelete);
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess(count($this->idBulkDelete) . ' items data successfully deleted');

        $this->idBulkDelete = [];
        dispatch(new ForgetCacheMenu());
    }

    public function render()
    {
        return view('rbac::livewire.navigation.navigation-table', [
            'results' => $this->menuService->getPageDataNavigation($this->filter)
        ]);
    }
}

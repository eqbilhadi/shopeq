<?php

namespace Modules\Rbac\Livewire\RoleManagement;

use App\Jobs\ForgetCacheMenu;
use Livewire\Component;
use Modules\Rbac\Services\RoleService;
use Livewire\WithPagination;

class RoleTable extends Component
{
    use WithPagination;

    protected $roleService;

    public $filter = [
        'search' => null
    ];

    public function boot(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function changeActiveStatus($id, $is_status)
    {
        $status = !$is_status;
        $this->roleService->changeActiveStatus($id, $status);
        dispatch(new ForgetCacheMenu());
    }

    public function delete($id)
    {
        $this->roleService->deleteRole($id);
        $this->dispatch('close-modal');
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess('Data successfully deleted');
        dispatch(new ForgetCacheMenu());
    }

    public function render()
    {
        return view('rbac::livewire.role-management.role-table', [
            'results' => $this->roleService->getPageDataRole($this->filter)
        ]);
    }
}

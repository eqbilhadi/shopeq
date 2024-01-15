<?php

namespace Modules\Rbac\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Rbac\Services\UserService;
use Modules\Rbac\Services\RoleService;

class UserTable extends Component
{
    use WithPagination;

    protected $userService;
    protected $roleService;

    public $filterOptionRole;

    public $filter = [
        'search' => null,
        'role' => null,
        'gender' => null,
    ];

    public function boot(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function changeActiveStatus($id, $is_status)
    {
        $status = !$is_status;
        $this->userService->changeActiveStatus($id, $status);
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        $this->dispatch('close-modal');
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess('Data successfully deleted');
    }

    public function render()
    {
        $this->filterOptionRole = $this->roleService->getRole();

        return view('rbac::livewire.user-management.user-table', [
            'results' => $this->userService->getPageDataUser($this->filter)
        ]);
    }
}

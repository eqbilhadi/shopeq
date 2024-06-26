<x-layouts-app.base title="Role Management">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName(), $role) }}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Manage Role</h4>

                        <div class="flex-shrink-0">
                            <a href="{{ route('rbac.role.index') }}" class="btn btn-danger" wire:navigate>Back</a>
                        </div>

                    </div>
                    <livewire:rbac::role-management.role-form :formType="request()->route()->getActionMethod()" :role="$role" />
                </div>
            </div>
        </div>
    </div>
</x-layouts-app.base>

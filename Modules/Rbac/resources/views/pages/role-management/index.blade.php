<x-layouts-app.base title="Role Management">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Table List Role</h4>

                        <div class="flex-shrink-0">
                            <a href="{{ route('rbac.role.create') }}" class="btn btn-primary">Add Role</a>
                        </div>

                    </div>
                    <livewire:rbac::role-management.role-table />
                </div>
            </div>
        </div>
    </div>
</x-layouts-app.base>
<x-layouts-app.base title="Navigation Management">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Create Navigation</h4>

                        <div class="flex-shrink-0">
                            <a href="{{ route('rbac.nav.index') }}" class="btn btn-danger">Back</a>
                        </div>

                    </div>
                    <livewire:rbac::navigation.navigation-form :formType="request()->route()->getActionMethod()" :menu=null />
                </div>
            </div>
        </div>
    </div>
</x-layouts-app.base>

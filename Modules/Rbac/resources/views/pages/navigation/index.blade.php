<x-layouts-app.base title="Navigation Management">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <livewire:rbac::navigation.navigation-table />
                </div>
            </div>
        </div>
    </div>
</x-layouts-app.base>

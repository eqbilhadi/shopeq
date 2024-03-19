<x-layouts-app.base title="Retur Purchase">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:purchasing::retur.retur-table />
            </div>
        </div>
    </div>
</x-layouts-app.base>

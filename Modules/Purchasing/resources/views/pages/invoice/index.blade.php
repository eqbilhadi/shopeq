<x-layouts-app.base title="Invoice Purchase">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:purchasing::invoice.invoice-table />
            </div>
        </div>
    </div>
</x-layouts-app.base>

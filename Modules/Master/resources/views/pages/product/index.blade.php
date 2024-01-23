<x-layouts-app.base title="Master Product">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::product.product-table />
            </div>
        </div>
    </div>
</x-layouts-app.base>

<x-layouts-app.base title="Invoice Purchase - Create">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:purchasing::invoice.create-invoice-page />
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('select-product', (event) => {
                document.getElementById("qty" + event.key).focus();
            });
        });
    </script>
</x-layouts-app.base>

<x-layouts-app.base title="Master Supplier">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::supplier.supplier-table />
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (event) => {
                $('#modalAddSupplier').modal('show');
            });
            
            Livewire.on('close-modal', (event) => {
                $('#modalAddSupplier').modal('hide');
            });

            $('#modalAddSupplier').on('shown.bs.modal', function() {
                $('#supplierName').focus();
            })
        });
    </script>
</x-layouts-app.base>

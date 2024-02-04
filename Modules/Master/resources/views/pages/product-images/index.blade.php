<x-layouts-app.base title="Product Images">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::product-images.product-image-table />
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (event) => {
                $('#editModal').modal('show');
            });
            
            Livewire.on('close-modal', (event) => {
                $('#editModal').modal('hide');
            });

            $('#editModal').on('shown.bs.modal', function() {
                $('input#title').focus();
            })
        });

    </script>
</x-layouts-app.base>

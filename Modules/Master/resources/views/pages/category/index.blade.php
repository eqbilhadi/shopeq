<x-layouts-app.base title="Master Category">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::category.category-table />
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (event) => {
                $('#modalAddCategory').modal('show');
            });
            
            Livewire.on('close-modal', (event) => {
                $('#modalAddCategory').modal('hide');
            });

            $('#modalAddCategory').on('shown.bs.modal', function() {
                $('#categoryName').focus();
            })
        });

    </script>
</x-layouts-app.base>

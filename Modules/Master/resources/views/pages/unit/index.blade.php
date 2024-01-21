<x-layouts-app.base title="Master Unit">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::unit.unit-table />
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (event) => {
                $('#modalAddUnit').modal('show');
            });
            
            Livewire.on('close-modal', (event) => {
                $('#modalAddUnit').modal('hide');
            });

            $('#modalAddUnit').on('shown.bs.modal', function() {
                $('#unitName').focus();
            })
        });

    </script>
</x-layouts-app.base>

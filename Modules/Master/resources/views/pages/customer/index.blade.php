<x-layouts-app.base title="Master Customer">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::customer.customer-table />
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', (event) => {
                $('#modalAddCustomer').modal('show');
                $('#userCustomer').select2({
                    dropdownParent: $('#modalAddCustomer')
                })
            });

            Livewire.on('close-modal', (event) => {
                $('#modalAddCustomer').modal('hide');
            });

            $('#modalAddCustomer').on('shown.bs.modal', function() {
                $('#customerName').focus();
            })

        });
    </script>

    @push('scripts')
        <!--select2 cdn-->
        <script src="{{ asset('assets/libs/select2/js/select2-new.min.js') }}"></script>

        <script>
            $(document).ready(function(){
                $('#userCustomer').select2({
                    dropdownParent: $('#modalAddCustomer')
                })
            })
            $(document).on('select2:open', function(e) {
                window.setTimeout(function() {
                    document.querySelector('input.select2-search__field').focus();
                }, 0);
            });
        </script>
    @endpush

    @push('select2css')
        <link href="{{ asset('assets/libs/select2/css/select2-new.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush
</x-layouts-app.base>

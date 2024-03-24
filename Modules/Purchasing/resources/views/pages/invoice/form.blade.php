<x-layouts-app.base title="Invoice Purchase">
    <div class="container-fluid">
        @if ($isEdit)
            {{ Breadcrumbs::render(Route::currentRouteName(), $invoice) }}
        @else
            {{ Breadcrumbs::render(Route::currentRouteName()) }}
        @endif
        <div class="row">
            <div class="col-xl-12">
                @if ($isEdit)
                    <livewire:purchasing::invoice.input-invoice :$invoice />
                @else
                    <livewire:purchasing::invoice.input-invoice />
                @endif

            </div>
        </div>
    </div>
    <style>
        .form-icon.right i {
            left: auto;
            right: 8px;
        }
    </style>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('reset-product', (event) => {
                const elementInput = $("input#productId" + event.key)
                elementInput.focus()
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            Livewire.on('select-product', (event) => {
                document.getElementById("qty" + event.key).focus();
            });
        });
    </script>
</x-layouts-app.base>

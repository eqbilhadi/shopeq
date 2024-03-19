<x-layouts-app.base title="Invoice Purchase">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:purchasing::invoice.input-invoice />
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
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('reset-product', (event) => {
                const elementInput = $("input#productId" + event.key)
                elementInput.focus()
            });
        });
    </script>
</x-layouts-app.base>

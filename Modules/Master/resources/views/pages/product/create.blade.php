<x-layouts-app.base title="Master Product">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName()) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::product.product-create />
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('input#number-format').forEach((element) => {
                    element.addEventListener('keyup', function(e) {
                        let cursorPostion = this.selectionStart;
                        let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                        let originalLenght = this.value.length;
                        if (isNaN(value)) {
                            this.value = "";
                        } else {
                            this.value = value.toLocaleString('id-ID', {
                                minimumFractionDigits: 0
                            });
                            cursorPostion = this.value.length - originalLenght + cursorPostion;
                            this.setSelectionRange(cursorPostion, cursorPostion);
                        }
                    });
                });
                document.querySelectorAll('input#number-only-format').forEach((element) => {
                    element.addEventListener('keyup', function(e) {
                        let cursorPostion = this.selectionStart;
                        let value = parseInt(this.value.replace(/[^,\d]/g, ''));
                        let originalLenght = this.value.length;
                        if (isNaN(value)) {
                            this.value = "";
                        } else {
                            this.value = value;
                            cursorPostion = this.value.length - originalLenght + cursorPostion;
                            this.setSelectionRange(cursorPostion, cursorPostion);
                        }
                    });
                });
            })
        </script>
    @endpush
</x-layouts-app.base>

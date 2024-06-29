<x-layouts-app.base title="Master Product - Edit">
    <div class="container-fluid">
        {{ Breadcrumbs::render(Route::currentRouteName(), $product) }}
        <div class="row">
            <div class="col-xl-12">
                <livewire:master::product.product-edit-page :product="$product" />
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    @endpush
</x-layouts-app.base>

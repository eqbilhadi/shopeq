<div>
    <form wire:submit='save'>
        <div class="d-flex gap-2 justify-content-end mb-3">
            <a href="{{ route('master.product.index') }}" class="btn btn-danger">Cancel</a>
            <button class="btn btn-primary" wire:loading.remove wire:target='save'>Save Changes</button>
            <button type="button" class="btn btn-primary btn-load" wire:loading wire:target='save'>
                <span class="d-flex align-items-center">
                    <span class="spinner-border flex-shrink-0" role="status"></span>
                    <span class="flex-grow-1 ms-2">
                        Loading ...
                    </span>
                </span>
            </button>
        </div>
    </form>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Product</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" placeholder="Enter product title" wire:model='form.name'>
                        @error('form.name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3" wire:ignore>
                        <label>Product Description</label>
                        <div id="ckeditor-classic">
                            {!! $form['description'] !!}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-2" dir="ltr">
                                <input type="checkbox" class="form-check-input" id="is-auto-barcode" wire:model.live='form.is_auto_barcode'>
                                <label class="form-check-label" for="is-auto-barcode">Auto Barcode</label>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter product barcode" wire:model='form.barcode' @disabled($form['is_auto_barcode'])>
                            @error('form.barcode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Minimal Stok</label>
                            <input type="text" class="form-control" placeholder="Enter product minimal stok" wire:model='form.minimal_stok' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })">
                            @error('form.minimal_stok')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Category</label>
                        <select class="form-select" wire:model='form.category_id'>
                            <option value="" disabled selected hidden>Select Category</option>
                            @foreach ($options['category'] as $ctg)
                                <option value="{{ $ctg['id'] }}">{{ $ctg['name'] }}</option>
                            @endforeach
                        </select>
                        @error('form.category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="card-header border-top">
                    <h3 class="card-title mb-0">Status Product</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="choices-publish-status-input" class="form-label">Status</label>

                        <select class="form-select" id="choices-publish-status-input" wire:model.live='form.status'>
                            <option value="" selected disabled hidden>Select Status</option>
                            @foreach ($options['status'] as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('form.status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div>
                        <label for="choices-publish-visibility-input" class="form-label">Visibility</label>
                        <select class="form-select" id="choices-publish-visibility-input" wire:model.live='form.visibility'>
                            <option value="" selected disabled hidden>Select Visibility</option>
                            @foreach ($options['visibility'] as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        @error('form.visibility')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Gallery</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="fs-15 mb-1">Product Image</h5>
                        <p class="text-muted">Add Product main Image.</p>
                        <div class="text-center">
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="position-relative d-inline-block">
                                    <div class="position-absolute top-100 start-100 translate-middle">
                                        <label for="product-image-input" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                            <div class="avatar-xs">
                                                <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                        </label>
                                        <input class="form-control d-none" id="product-image-input" type="file" wire:model.live='form.images.main_image.filename'>
                                    </div>
                                    <div class="avatar-lg">
                                        <div class="avatar-title bg-light rounded">
                                            @if ($form['images']['main_image']['filename'])
                                                @unless ($errors->has('form.images.main_image.filename'))
                                                    @if ($form['images']['main_image']['filename'] instanceof \Illuminate\Http\UploadedFile)
                                                        <img src="{{ $form['images']['main_image']['filename']?->temporaryUrl() }}" alt="main-image-product" class="avatar-xl">
                                                    @else
                                                        <img src="{{ $form['images']['main_image']['src'] }}" alt="main-image-product" class="avatar-xl h-auto">
                                                    @endif
                                                @else
                                                    <img src="{{ $form['images']['main_image']['src'] }}" alt="main-image-product" class="avatar-xl h-auto">
                                                @endunless
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div x-show="isUploading" style="display: none">
                                    <div class="card bg-light overflow-hidden mt-3">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0"><b x-text="progress + '%'"></b> &nbsp;&nbsp;&nbsp; Uploading image in progress...</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="progress bg-soft-secondary rounded-0">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" :style="'width: ' + progress + '%'" aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-center mt-4">
                            @error('form.images.main_image.filename')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <h5 class="fs-15 mb-1">Product Gallery</h5>
                    <p class="text-muted">Add Product Gallery Images.</p>

                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="border border-dashed text-center">
                            <input type="file" wire:model.live='form.other_image' class="d-none" id="product-gallery-image upload">
                            <div class="pt-3">
                                <label for="product-gallery-image upload">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                    </div>

                                    <h5>Click here to upload product images.</h5>
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            @error('form.other_image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div x-show="isUploading" style="display: none">
                            <div class="card bg-light overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0"><b x-text="progress + '%'"></b> &nbsp;&nbsp;&nbsp; Uploading image in progress...</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress bg-soft-secondary rounded-0">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" :style="'width: ' + progress + '%'" aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                        @if ($form['images']['other_image'])
                            @foreach ($form['images']['other_image'] as $key => $img)
                                <li class="mt-2" id="dropzone-preview-list">
                                    <div class="border rounded">
                                        <div class="d-flex p-2">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm bg-light rounded">
                                                    @if ($img['filename'] instanceof \Illuminate\Http\UploadedFile)
                                                        <img src="{{ $img['filename']?->temporaryUrl() }}" alt="other-image-product-{{ $key }}" class="rounded avatar-sm">
                                                    @else
                                                        <img src="{{ $img['src'] }}" alt="other-image-product-{{ $key }}" class="rounded avatar-sm">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="pt-1">
                                                    @if ($img['filename'] instanceof \Illuminate\Http\UploadedFile)
                                                        <h5 class="fs-14 mb-1">{{ $img['filename']->getClientOriginalName() }}</h5>
                                                        <p class="fs-13 text-muted mb-0">{{ round($img['filename']->getSize() / 1024, 2) }} KB</p>
                                                    @else
                                                        <h5 class="fs-14 mb-1">{{ basename($img['filename']) }}</h5>
                                                        <p class="fs-13 text-muted mb-0">{{ round(filesize($img['filename']) / 1024, 2) }} KB</p>
                                                    @endif
                                                    <strong class="error text-danger"></strong>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 ms-3">
                                                <button type="button" class="btn btn-sm btn-danger" wire:click='removeOtherImage("{{ $key }}")'>Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-8">
                            <h5 class="card-title mb-0">Product Unit</h5>
                        </div>
                        <div class="col-lg-4">
                            <button type="button" class="float-end btn btn-primary btn-sm mb-2" wire:click='addOtherUnit'>Add Another Unit</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <select class="form-select" wire:model='form.units.main_unit.unit_id'>
                        <option value="" selected disabled hidden>Select main unit product</option>
                        @foreach ($options['unit'] as $unit)
                            <option value="{{ $unit['id'] }}">{{ $unit['name'] }}</option>
                        @endforeach
                    </select>
                    @error('form.units.main_unit.unit_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Purchase price" style="text-align: right" wire:model.live.debounce.300ms='form.units.main_unit.purchase_price' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                            @error('form.units.main_unit.purchase_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Selling price" style="text-align: right" wire:model.live.debounce.300ms='form.units.main_unit.selling_price' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                            @error('form.units.main_unit.selling_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @foreach ($form['units']['other_unit'] as $key => $other_unit)
                        <div class="mb-5 border-bottom pt-5"></div>
                        <div class="d-flex gap-2 flex-column">
                            <div class="w-100">
                                <select class="form-select w-100" wire:model.live='form.units.other_unit.{{ $key }}.unit_id'>
                                    <option value="" selected disabled hidden>Select other unit product</option>
                                    @foreach ($options['unit'] as $unit)
                                        <option value="{{ $unit['id'] }}">{{ $unit['name'] }}</option>
                                    @endforeach
                                </select>
                                @error("form.units.other_unit.{$key}.unit_id")
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })" class="form-control" wire:model='form.units.other_unit.{{ $key }}.convert_main' placeholder="Conversion of main unit" style="text-align: right">
                                    @error("form.units.other_unit.{$key}.convert_main")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })" class="form-control" wire:model='form.units.other_unit.{{ $key }}.convert_other' placeholder="Conversion to other unit" style="text-align: right">
                                    @error("form.units.other_unit.{$key}.convert_other")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Purchase price" style="text-align: right" wire:model='form.units.other_unit.{{ $key }}.purchase_price' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                                    @error("form.units.other_unit.{$key}.purchase_price")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Selling price" style="text-align: right" wire:model.live.debounce.300ms='form.units.other_unit.{{ $key }}.selling_price' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                                    @error("form.units.other_unit.{$key}.selling_price")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger h-100" wire:click='removeOtherUnit("{{ $key }}")'><i class="fa-duotone fa-trash"></i></button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                ClassicEditor.create(document.querySelector("#ckeditor-classic")).then(function(e) {
                    e.ui.view.editable.element.style.height = "410px"
                    e.model.document.on('change:data', () => {
                        @this.set('form.description', e.getData());
                    })
                }).catch(function(e) {
                    console.error(e)
                });
            });
        </script>
    @endpush
</div>

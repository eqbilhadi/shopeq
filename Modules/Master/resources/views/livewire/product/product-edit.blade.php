<div>
    <form wire:submit='save'>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="mb-3 col-12">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" placeholder="Enter product title" wire:model.live.debounce.200ms='form.name'>
                                @error('form.name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12" wire:ignore>
                                <label>Product Description</label>
                                <div id="ckeditor-classic">
                                    {!! $form->description !!}
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Purchase Price</label>
                                <input type="text" class="form-control" placeholder="Enter product purchase price" style="text-align: right" wire:model.live.debounce.300ms='form.purchasePrice' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                                @error('form.purchasePrice')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Selling Price</label>
                                <input type="text" class="form-control" placeholder="Enter product selling price" style="text-align: right" wire:model.live.debounce.300ms='form.sellingPrice' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                                @error('form.sellingPrice')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-2" dir="ltr">
                                    <input type="checkbox" class="form-check-input" id="isAutoBarcode" wire:model.live='form.isAutoBarcode'>
                                    <label class="form-check-label" for="isAutoBarcode">Auto Barcode</label>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter product barcode" @disabled($form->isAutoBarcode) wire:model.live.debounce.200ms='form.barcode'>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Minimal Stok</label>
                                <input type="text" class="form-control" placeholder="Enter product minimal stok" wire:model.live.debounce.200ms='form.minimalStok' x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })">
                            </div>
                        </div>
                    </div>
                </div>


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
                                            <input class="form-control d-none" id="product-image-input" type="file" wire:model='form.mainImages'>
                                        </div>
                                        <div class="avatar-lg">
                                            <div class="avatar-title bg-light rounded">
                                                @if ($form->mainImages)
                                                    @unless ($errors->has('form.mainImages'))
                                                        <img src="{{ $form->mainImages->temporaryUrl() }}" alt="" class="avatar-xl">
                                                    @endunless
                                                @else
                                                    <img src="{{ $form->previewMainImage }}" alt="" class="avatar-xl h-auto">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div x-show="isUploading">
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
                                @error('form.mainImages')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <h5 class="fs-15 mb-1">Product Gallery</h5>
                            <p class="text-muted">Add Product Gallery Images.</p>

                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false; progress = 0" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="border border-dashed text-center">
                                    <input type="file" wire:model='form.images' class="d-none" id="product-gallery-image upload{{ $form->iteration }}">
                                    <div class="pt-3">
                                        <label for="product-gallery-image upload{{ $form->iteration }}">
                                            <div class="mb-3">
                                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                            </div>

                                            <h5>Click here to upload product images.</h5>
                                        </label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    @error('form.images')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div x-show="isUploading">
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
                                @foreach ($form->previewStageImages as $key => $img)
                                    <li class="mt-2" id="dropzone-preview-list">
                                        <div class="border rounded">
                                            <div class="d-flex p-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm bg-light rounded">
                                                        <img src="{{ $img['src'] }}" alt="" class="rounded avatar-sm">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="pt-1">
                                                        @if (file_exists(public_path($img['filename'])))
                                                            <h5 class="fs-14 mb-1">{{ basename($img['filename']) }}</h5>
                                                            <p class="fs-13 text-muted mb-0">{{ round(filesize($img['filename']) / 1024, 2) }} KB</p>
                                                            <strong class="error text-danger"></strong>
                                                        @else
                                                            <h5 class="fs-14 mb-1">Not Found Image</h5>
                                                            <p class="fs-13 text-muted mb-0">~ KB</p>
                                                            <strong class="error text-danger"></strong>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-3">
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteSubImage" data-delete-id={{ "$img[idImage]" }} data-delete-key={{ "$key" }}>Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                @if ($form->stageImages)
                                    @foreach ($form->stageImages as $key => $img)
                                        <li class="mt-2" id="dropzone-preview-list">
                                            <div class="border rounded">
                                                <div class="d-flex p-2">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm bg-light rounded">
                                                            <img src="{{ $img->temporaryUrl() }}" alt="" class="rounded avatar-sm">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="pt-1">
                                                            <h5 class="fs-14 mb-1">{{ $img->getClientOriginalName() }}</h5>
                                                            <p class="fs-13 text-muted mb-0">{{ round($img->getSize() / 1024, 2) }} KB</p>
                                                            <strong class="error text-danger"></strong>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ms-3">
                                                        <button type="button" class="btn btn-sm btn-danger" wire:click='deleteTemporaryImg("{{ $key }}")'>Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="choices-publish-status-input" class="form-label">Status</label>

                            <select class="form-select" id="choices-publish-status-input" wire:model.live='form.status'>
                                <option value="" selected disabled hidden>Select Status</option>
                                <option value="published" selected>Published</option>
                                <option value="draft">Draft</option>
                            </select>
                            @error('form.status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div>
                            <label for="choices-publish-visibility-input" class="form-label">Visibility</label>
                            <select class="form-select" id="choices-publish-visibility-input" wire:model.live='form.visibility'>
                                <option value="" selected disabled hidden>Select Visibility</option>
                                <option value="public" selected>Public</option>
                                <option value="hidden">Hidden</option>
                            </select>
                            @error('form.visibility')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Categories</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-2"> <a href="{{ route('master.category.index') }}" class="float-end text-decoration-underline mb-2">Add New</a></p>
                        <select class="form-select" wire:model.live='form.categoryId'>
                            <option value="" disabled selected hidden>Select Product Category</option>
                            @foreach ($categoryOptions as $ctg)
                                <option value="{{ $ctg->id }}">{{ $ctg->name }}</option>
                            @endforeach
                        </select>
                        @error('form.categoryId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Unit</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Add Product Main Unit. <button type="button" class="float-end btn btn-primary btn-sm mb-2" wire:click='addSubUnit'>Add Another Unit</button></p>
                        <select class="form-select" wire:model.live='form.mainUnitId'>
                            <option value="" selected disabled hidden>Select main unit product</option>
                            @foreach ($unitOptions as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('form.mainUnitId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        @foreach ($form->editUnitId as $key => $unit)
                            <div class="mb-4 border-bottom pt-4"></div>
                            <div class="d-flex gap-2 flex-column">
                                <div class="w-100">
                                    <select class="form-select w-100" wire:model.live='form.editUnitId.{{ $key }}'>
                                        <option value="" selected disabled hidden>Select other unit product</option>
                                        @foreach ($unitOptions as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error("form.editUnitId.{$key}")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="w-50">
                                        <input type="text" class="form-control" wire:model='form.editConvertMain.{{ $key }}' placeholder="Conversion of main unit" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })">
                                        @error("form.editConvertMain.{$key}")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="w-50">
                                        <input type="text" class="form-control" wire:model='form.editConvertOther.{{ $key }}' placeholder="Conversion to other unit" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })">
                                        @error("form.editConvertOther.{$key}")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-danger w-100 h-100" wire:click='deleteSubUnit("{{ $key }}")'><i class="fa-duotone fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($inputSubUnit as $key => $subUnit)
                            <div class="mb-4 border-bottom pt-4"></div>
                            <div class="d-flex gap-2 flex-column">
                                <div class="w-100">
                                    <select class="form-select w-100" wire:model.live='form.unitId.{{ $key }}'>
                                        <option value="" selected disabled hidden>Select other unit product</option>
                                        @foreach ($unitOptions as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error("form.unitId.{$key}")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="d-flex gap-2">
                                    <div class="w-50">
                                        <input type="text" class="form-control" wire:model='form.convertMain.{{ $key }}' placeholder="Conversion of main unit" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })">
                                        @error("form.convertMain.{$key}")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="w-50">
                                        <input type="text" class="form-control" wire:model='form.convertOther.{{ $key }}' placeholder="Conversion to other unit" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: '', delimiter: '' })">
                                        @error("form.convertOther.{$key}")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger h-100" wire:click='removeSubUnit("{{ $key }}")'><i class="fa-duotone fa-trash"></i></button>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('master.product.index') }}" class="btn btn-danger">Cancel</a>
                            <button class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div wire:ignore.self class="modal fade" id="confirmDeleteSubImage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure, you want to remove this image?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification" wire:loading.remove>Yes, Delete It!</button>
                        <button type="button" class="btn btn-danger btn-load" wire:loading>
                            <span class="d-flex align-items-center">
                                <span class="spinner-grow flex-shrink-0" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </span>
                                <span class="flex-grow-1 ms-2">
                                    Loading...
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:init', () => {
                ClassicEditor.create(document.querySelector("#ckeditor-classic")).then(function(e) {
                    e.ui.view.editable.element.style.height = "200px"
                    e.model.document.on('change:data', () => {
                        @this.set('form.description', e.getData());
                    })
                }).catch(function(e) {
                    console.error(e)
                });
            });

            Livewire.on('close-modal', (event) => {
                $("#confirmDeleteSubImage").modal('hide');
            });

            $("#confirmDeleteSubImage").on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('delete-id');
                var key = $(e.relatedTarget).data('delete-key');
                $(e.currentTarget).find('button#delete-notification').attr('wire:click', 'deleteSubImage("' + id + '", "' + key + '")');
            });
        </script>
    @endpush
</div>

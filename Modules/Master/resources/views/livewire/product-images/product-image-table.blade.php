<div>
    @push('styles')
        <style>
            .image-container {
                width: 250px;
                height: 250px;
            }

            .image-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
    @endpush
    <div class="card shadow">
        <div class="row">
            <div class="col-lg-12">
                <div class="">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="text-center">
                                    <ul class="list-inline categories-filter animation-nav" id="filter">
                                        <li class="list-inline-item" wire:click='setFilter("")'><a class="categories @if ($filter['category'] == '') active @endif" data-filter="*">All</a></li>
                                        @foreach ($category as $ctg)
                                            <li class="list-inline-item" wire:click='setFilter("{{ $ctg->id }}")'><a class="categories @if ($filter['category'] == $ctg->id) active @endif">{{ $ctg->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="row gallery-wrapper">
                                    @foreach ($images as $img)
                                        <div class="element-item col-xxl-3 col-xl-4 col-sm-6 project designing development" wire:key="{{ $img->id }}">
                                            <div class="gallery-box card">
                                                <div class="gallery-container border">
                                                    <a class="image-popup d-flex justify-content-center">
                                                        <div class="image-container d-flex justify-content-center">
                                                            <img src="{{ $img->img_url }}" alt="{{ basename($img->filename) }}">
                                                        </div>
                                                        <div class="gallery-overlay">
                                                            <h5 class="overlay-caption">{{ $img->imageable->name }}</h5>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="box-content">
                                                    <div class="d-flex align-items-center justify-content-end mt-1">
                                                        <div class="d-flex gap-2">
                                                            <button type="button" class="btn btn-sm fs-13 btn-link text-body text-decoration-none px-0" wire:loading.remove wire:target='edit("{{ $img->id }}")' wire:click='edit("{{ $img->id }}")'>
                                                                <i class="fa-sharp fa-solid fa-pen-to-square"></i> Edit
                                                            </button>
                                                            <button type="button" class="btn btn-sm fs-13 btn-link text-body text-decoration-none d-none px-0" wire:loading.class.remove="d-none" wire:target='edit("{{ $img->id }}")'>
                                                                <i class="fa-sharp fa-solid fa-circle-notch fa-spin"></i> Loading
                                                            </button>
                                                            <button type="button" class="btn btn-sm fs-13 btn-link text-body text-decoration-none px-0"  data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id={{ "$img->id" }}>
                                                                <i class="fa-sharp fa-solid fa-trash"></i> Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-center my-2 d-none" wire:target='loadMore' wire:loading.class.remove='d-none'>
                                    <a href="javascript:void(0);" class="text-primary"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load More </a>
                                </div>

                                <div x-data="{
                                    observe() {
                                        const observer = new IntersectionObserver((product) => {
                                            product.forEach(prd => {
                                                if (prd.isIntersecting) {
                                                    @this.loadMore()
                                                }
                                            })
                                        })
                                        observer.observe(this.$el)
                                    }
                                }" x-init="observe"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <form wire:submit="update('{{ $image->id ?? '-' }}')" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <img class="card-img rounded-0 img-fluid border border-dark" src="{{ $image->img_url ?? null }}" alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Image Title</label>
                                    <input type="text" id="title" class="form-control" placeholder="Enter image title" wire:model='title' />
                                </div>

                                <div class="mb-3">
                                    <label for="source" class="form-label">Image Source</label>
                                    <input type="text" id="source" class="form-control" placeholder="Enter source of image" wire:model='source' />
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" class="form-control" rows="7" placeholder="Enter description" wire:model='description'></textarea>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="add-btn">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-delete-modal />
</div>

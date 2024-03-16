<div>
    <div class="card shadow">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Table List Category</h4>
            <div class="flex-shrink-0">
                @if (count($idBulkDelete) > 0)
                    <small class="text-danger fs-11 me-1">{{ count($idBulkDelete) }} items selected</small><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">Delete</button>
                @endif
                <button type="button" class="btn btn-primary" wire:click='openModal("add")' wire:loading.remove wire:target='openModal("add")'>
                    Add Supplier
                </button>
                <button type="button" class="btn btn-primary btn-load" wire:loading wire:target='openModal("add")'>
                    <span class="d-flex align-items-center">
                        <span class="spinner-border flex-shrink-0" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span class="flex-grow-1 ms-2">
                            Loading...
                        </span>
                    </span>
                </button>
            </div>
        </div>
        <div class="card-header">
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Search..." wire:model.live='filter.search'>
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table align-middle table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width:1%">No</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col" style="width: 150px;" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $r)
                            <tr wire:key='{{ $r->id }}'>
                                <td class="text-center">{{ $results->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $r->id }}" wire:model.live='idBulkDelete' value="{{ $r->id }}">
                                        <label class="form-check-label" for="{{ $r->id }}">
                                            {{ $r->name }}
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $r->phone }}</td>
                                <td>{{ $r->address }}</td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-sm btn-warning" wire:click='openModal("update", "{{ $r->id }}")' wire:loading.remove wire:target='openModal("update", "{{ $r->id }}")'>Edit</button>
                                        <button type="button" class="btn btn-sm btn-warning btn-load" wire:loading wire:target='openModal("update", "{{ $r->id }}")'>
                                            <span class="d-flex align-items-center">
                                                <span class="spinner-border flex-shrink-0" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </span>
                                                <span class="flex-grow-1 ms-2">
                                                    Loading...
                                                </span>
                                            </span>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id={{ "$r->id" }}>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($results->isEmpty())
                            <td colspan="100%" class="text-center"><b>No data available in table</b></td>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($results->hasPages())
            <div class="card-footer border-0">
                {{ $results->links('components.pagination') }}
            </div>
        @else
            <div class="card-footer border-0 pb-0">
                <ul class="pagination pagination-sm">
                    @if ($results->isNotEmpty())
                        {{ __('Showing') }} {{ ($results->currentpage() - 1) * $results->perpage() + 1 }} {{ __('to') }}
                        {{ min($results->currentPage() * $results->perPage(), $results->total()) }}
                        {{ __('of') }} {{ $results->total() }}
                        {{ __('entries') }}
                    @else
                        {{ __('Showing') }} 0 {{ __('to') }} 0 {{ __('of') }} 0 {{ __('entries') }}
                    @endif

                </ul>
            </div>
        @endif
    </div>

    <div wire:ignore.self class="modal fade zoomIn" id="modalAddSupplier" tabindex="-1" aria-labelledby="modalAddSupplierLabel" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddSupplierLabel">{{ $filter['modalTitle'] }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit='save'>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-xxl-12">
                                <div>
                                    <label for="supplierName" class="form-label">Supplier Name</label>
                                    <input type="text" class="form-control" id="supplierName" placeholder="Enter supplier name" wire:model.live='form.name' autocomplete="off">
                                    @error('form.name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-12">
                                <div>
                                    <label for="phoneNumber" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phoneNumber" placeholder="Enter phone number" wire:model.live='form.phone' autocomplete="off">
                                    @error('form.phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-12">
                                <div>
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" placeholder="Enter address" wire:model.live='form.address' autocomplete="off">
                                    @error('form.address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="float-end">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" wire:loading.remove wire:target='save'>Save Changes</button>
                            <button type="button" class="btn btn-primary btn-load" wire:loading wire:target='save'>
                                <span class="d-flex align-items-center">
                                    <span class="spinner-border flex-shrink-0" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                    <span class="flex-grow-1 ms-2">
                                        Loading...
                                    </span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-delete-modal />
    <x-bulk-delete-modal :count="count($idBulkDelete)" />
</div>

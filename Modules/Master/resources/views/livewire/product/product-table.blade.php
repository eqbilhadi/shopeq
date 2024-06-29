<div>
    <div class="card shadow">
        <div class="card-header align-items-center d-flex">
            <h3 class="card-title mb-0 flex-grow-1">Table List Product</h3>
            <div class="flex-shrink-0">
                <a href="{{ route('master.product.create') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-2">
                    <select class="form-select" wire:model.live='filter.category'>
                        <option value="">All Category</option>
                        @foreach ($options['category'] as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live='filter.status'>
                        <option value="">All Status</option>
                        @foreach ($options['status'] as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live='filter.visibility'>
                        <option value="">All Visibility</option>
                        @foreach ($options['visibility'] as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 offset-md-3">
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
                            <th scope="col">Product Name</th>
                            <th scope="col" class="text-center" style="width:7%">Status</th>
                            <th scope="col" class="text-end">Purchase Price</th>
                            <th scope="col" class="text-end">Selling Price</th>
                            <th scope="col" style="width: 15%;" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $r)
                            <tr wire:key='{{ $r->id }}' wire:loading.remove wire:target="filter">
                                <td class="text-center">{{ $results->firstItem() + $loop->index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-md bg-light rounded p-1 me-3">
                                            <img src="{{ $r->main_image_url }}" alt="" class="img-fluid d-block">
                                        </div>
                                        <div>
                                            <h5 class="fs-14 my-1">{{ $r->name }}</h5>
                                            <span class="text-muted">{{ $r->category->name ?? 'has no category' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($r->status == 'published')
                                        <span class="badge badge-soft-primary badge-border d-block mb-3">Published</span>
                                    @else
                                        <span class="badge badge-soft-danger badge-border d-block mb-3">Draft</span>
                                    @endif
                                    @if ($r->visibility == 'public')
                                        <span class="badge badge-soft-success badge-border d-block">Public</span>
                                    @else
                                        <span class="badge badge-soft-secondary badge-border d-block">Private</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @foreach ($r->units as $unit)
                                        <div>
                                            @if ($unit->is_main_unit)
                                                <h5 class="fs-14 my-1">{{ $unit->purchase_price_format }} / {{ $unit->unit->name }}</h5>
                                            @else
                                                <small class="text-muted">{{ $unit->purchase_price_format }} / {{ $unit->unit->name }}</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    @foreach ($r->units as $unit)
                                        <div>
                                            @if ($unit->is_main_unit)
                                                <h5 class="fs-14 my-1">{{ $unit->selling_price_format }} / {{ $unit->unit->name }}</h5>
                                            @else
                                                <small class="text-muted">{{ $unit->selling_price_format }} / {{ $unit->unit->name }}</small>
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('master.product.edit', $r->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id={{ "$r->id" }}>
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="d-none" wire:loading.class.remove="d-none" wire:target="filter" wire:key="938473294">
                            <td colspan="7" class="text-center">
                                <div class="spinner-border spinner-border-sm text-dark" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </td>
                        </tr>
                        @if ($results->isEmpty())
                            <tr wire:loading.remove wire:target="filter" wire:key="23901238">
                                <td colspan="7" class="text-center"><b>No data available in table</b></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer border-0 pb-0">
            {{ $results->links() }}
        </div>
    </div>
    <x-delete-modal />
</div>

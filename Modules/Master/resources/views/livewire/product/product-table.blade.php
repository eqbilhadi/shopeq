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
                        @foreach ($categoryOptions as $opt)
                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live='filter.status'>
                        <option value="">All Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live='filter.visibility'>
                        <option value="">All Visibility</option>
                        <option value="public">Public</option>
                        <option value="hidden">Private</option>
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
                            <th scope="col" style="width: 20%">Category</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Purchase Price</th>
                            <th scope="col" class="text-end">Selling Price</th>
                            <th scope="col" style="width: 15%;" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $r)
                            <tr wire:key='{{ $r->id }}' wire:loading.remove wire:target="filter">
                                <td class="text-center">{{ $results->firstItem() + $loop->index }}</td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->category->name ?? null }}</td>
                                <td>
                                    @if ($r->status == 'published')
                                        <span class="badge badge-soft-primary badge-border">Published</span>
                                    @else
                                        <span class="badge badge-soft-danger badge-border">Draft</span>
                                    @endif
                                    @if ($r->visibility == 'public')
                                        <span class="badge badge-soft-success badge-border">Public</span>
                                    @else
                                        <span class="badge badge-soft-secondary badge-border">Private</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ $r->purchase_price_format }}</td>
                                <td class="text-end">{{ $r->selling_price_format }}</td>
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
    <x-delete-modal />
</div>

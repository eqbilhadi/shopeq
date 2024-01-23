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
                    <select class="form-select">
                        <option value="">All Category</option>
                        @foreach ($categoryOptions as $opt)
                            <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 offset-md-7">
                    <input type="text" class="form-control" placeholder="Search...">
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
                            <th scope="col" class="text-end">Purchase Price</th>
                            <th scope="col" class="text-end">Selling Price</th>
                            <th scope="col" style="width: 15%;" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $r)
                            <tr wire:key='{{ $r->id }}'>
                                <td class="text-center">{{ $results->firstItem() + $loop->index }}</td>
                                <td class="text-center">
                                    <!-- Base Example -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $r->id }}" wire:model.live='form.idBulkDelete' value="{{ $r->id }}">
                                        <label class="form-check-label" for="{{ $r->id }}">
                                            {{ $r->name }}
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $r->category->name ?? null }}</td>
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
                        @if ($results->isEmpty())
                            <td colspan="6" class="text-center"><b>No data available in table</b></td>
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
                    {{ __('Showing') }} {{ ($results->currentpage() - 1) * $results->perpage() + 1 }} {{ __('to') }}
                    {{ min($results->currentPage() * $results->perPage(), $results->total()) }}
                    {{ __('of') }} {{ $results->total() }}
                    {{ __('entries') }}
                </ul>
            </div>
        @endif
    </div>
    <x-delete-modal />
</div>

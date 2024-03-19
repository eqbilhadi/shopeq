<div>
    <div class="card shadow">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Table List Purchasing Invoice</h4>
            <div class="flex-shrink-0">
                <a href="{{ route('purchasing.invoice.create') }}" class="btn btn-primary" wire:navigate>
                    Add Invoice
                </a>
                <button type="button" class="btn btn-primary btn-load" wire:loading wire:target='openModal("add", "test")'>
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
            <div class="d-flex justify-content-between">
                <div class="d-flex gap-3 align-items-center">
                    <input type="date" class="form-control" wire:model.live='filter.startDate'>
                    <div>to</div>
                    <input type="date" class="form-control" wire:model.live='filter.endDate'>
                </div>
                <div class="d-flex">
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
                            <th scope="col">No Invoice</th>
                            <th scope="col">Purchasing Date</th>
                            <th scope="col">Supplier</th>
                            <th scope="col" class="text-end" style="width: 20%">Total</th>
                            <th scope="col" style="width: 150px;" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $r)
                            <tr wire:key='{{ $r->id }}'>
                                <td class="text-center">{{ $results->firstItem() + $loop->index }}</td>
                                <td>{{ $r->invoice_no }}</td>
                                <td>{{ $r->transaction_date }}</td>
                                <td>{{ $r->supplier->name }}</td>
                                <td class="text-end">Rp. {{ number_format($r->orderItems->sum('total_price'), 2, ',', '.') }}</td>
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
</div>

<div>
    <div class="card shadow">
        <div class="card-header align-items-center d-flex justify-content-between">
            <h4 class="card-title mb-0 flex-grow-1">
                Create Purchasing Invoice
            </h4>
            <div>
                <a href="{{ route('purchasing.invoice.index') }}" class="btn btn-danger">Back</a>
                <button type="button" class="btn btn-primary" wire:click='finishCreateInvoice'>
                    <i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.7s;" wire:loading wire:target="finishCreateInvoice"></i>
                    Save Invoice
                </button>
            </div>
        </div>
        @error('form.transaction')
            <div class="alert alert-warning alert-border-left alert-dismissible fade show mx-3 mt-3" role="alert">
                <i class="ri-alert-line me-3 align-middle"></i> <strong>Warning</strong> - {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        @if (!is_null($transaction))
            <div class="card-header align-items-center d-flex justify-content-between">
                <div class="d-flex flex-column gap3">
                    <h4 class="card-title mb-0 flex-grow-1">Current Invoice : {{ $transaction->invoice_no }}</h4>
                    <small class="text-bold">Total Price : Rp. {{ number_format($transaction->orderItems->sum('total_price'), 2, ',', '.') }}</small>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-danger" wire:click='cancelInput'>
                        <i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.7s;" wire:loading wire:target="cancelInput"></i>
                        Cancel
                    </button>
                </div>
            </div>
        @endif
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 border-bottom pb-3">
                    <div class="row g-3">
                        <div class="col-lg-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="invoiceNo" placeholder="Enter invoice no" wire:model='form.transaction.invoice_no'>
                                <label for="invoiceNo">Invoice Number</label>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="invoiceDate" wire:model='form.transaction.transaction_date'>
                                <label for="invoiceDate">Date</label>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-floating">
                                <select class="form-select" id="supplierOptions" wire:model='form.transaction.supplier_id'>
                                    <option value="">Select Supplier</option>
                                    @foreach ($options['supplier'] as $spl)
                                        <option value="{{ $spl['id'] }}">{{ $spl['name'] }}</option>
                                    @endforeach
                                </select>
                                <label for="supplierOptions">Supplier</label>
                            </div>
                            @error('form.transaction.supplier_id')
                                <span class="form-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="note" placeholder="Enter your note transaction" wire:model='form.transaction.description'>
                                <label for="note">Note</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 py-3">
                    <h4 class="card-title mb-0 flex-grow-1 pb-3">List Item Order Transaction</h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width:1%">No</th>
                                    <th scope="col" style="width: 40%">Product</th>
                                    <th scope="col" style="width: 7%" class="text-center">Qty</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col" class="text-right" style="width: 15%">Price (Rp.)</th>
                                    <th scope="col" class="text-right" style="width: 15%">Total (Rp.)</th>
                                    <th scope="col" style="width: 90px;" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form['item_orders'] as $key => $order)
                                    <tr wire:key='table-key-{{ $key }}' class="align-middle">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <livewire:purchasing::components.search-product :keys="$key" :productname="$order['product_name']" :key="$key" />
                                            @error("form.item_orders.{$key}.product_id")
                                                <span class="form-text text-danger py-0" style="font-size: 8pt">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="form.item_orders.{{ $key }}.qty" id="qty{{ $key }}" style="text-align: center" wire:keydown.enter.prevent="saveOrderItem({{ $key }})">
                                            @error("form.item_orders.{$key}.qty")
                                                <span class="form-text text-danger py-0" style="font-size: 8pt">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm" wire:model.live.debounce.500ms='form.item_orders.{{ $key }}.unit_product_id'>
                                                @foreach ($options['unit_product'][$key] as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->unit->name }}</option>
                                                @endforeach
                                            </select>
                                            @error("form.item_orders.{$key}.unit_product_id")
                                                <span class="form-text text-danger py-0" style="font-size: 8pt">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="form.item_orders.{{ $key }}.price" style="text-align: right" wire:keydown.enter.prevent="saveOrderItem({{ $key }})" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                                            @error("form.item_orders.{$key}.price")
                                                <span class="form-text text-danger py-0" style="font-size: 8pt">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" @readonly(true) wire:model="form.item_orders.{{ $key }}.total_price" style="text-align: right" x-data x-init="new Cleave($el, { numeral: true, numeralDecimalMark: ',', delimiter: '.' })">
                                            @error("form.item_orders.{$key}.total_price")
                                                <span class="form-text text-danger py-0" style="font-size: 8pt">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="text-end">
                                            <button class="btn @if (!is_null($order['transaction_item'])) btn-warning @else btn-primary @endif btn-icon btn-sm waves-effect waves-light" wire:click.prevent="saveOrderItem({{ $key }})" wire:loading.attr="disabled" wire:target="saveOrderItem({{ $key }})">
                                                @if (!is_null($order['transaction_item']))
                                                    <i class="fa-sharp fa-solid fa-pencil" wire:loading.remove wire:target="saveOrderItem({{ $key }})"></i>
                                                    <i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.7s;" wire:loading wire:target="saveOrderItem({{ $key }})"></i>
                                                @else
                                                    <i class="fa-sharp fa-solid fa-floppy-disk" wire:loading.remove wire:target="saveOrderItem({{ $key }})"></i>
                                                    <i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.7s;" wire:loading wire:target="saveOrderItem({{ $key }})"></i>
                                                @endif
                                            </button>
                                            @if (count($form['item_orders']) > 1 && !is_null($order['transaction_item']))
                                                <button type="button" class="btn btn-danger btn-icon btn-sm waves-effect waves-light" wire:loading.attr="disabled" wire:click.prevent="deleteOrderItem({{ $key }})" wire:target="deleteOrderItem({{ $key }})">
                                                    <i class="fa-sharp fa-solid fa-trash" wire:loading.remove wire:target="deleteOrderItem({{ $key }})"></i>
                                                    <i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.7s;" wire:loading wire:target="deleteOrderItem({{ $key }})"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

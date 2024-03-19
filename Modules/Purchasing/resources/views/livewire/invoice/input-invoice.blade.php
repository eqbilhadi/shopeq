<div>
    <div class="card shadow">
        <div class="card-header align-items-center d-flex justify-content-between">
            <h4 class="card-title mb-0 flex-grow-1">Create Purchasing Invoice</h4>
            <div>
                <a href="{{ route('purchasing.invoice.index') }}" class="btn btn-danger" wire:navigate>Back</a>
                <button type="button" class="btn btn-primary" wire:click='finishInput'>
                    <i class="fa-solid fa-spinner-third fa-spin" style="--fa-animation-duration: 0.7s;" wire:loading wire:target="finishInput"></i>
                    Save Invoice
                </button>
            </div>
        </div>
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
        <div class="card-body py-0">
            <div class="row">
                <div class="col-lg-12 border-bottom py-3">
                    <form wire:submit='save'>
                        <div class="row g-3">
                            <div class="col-lg-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="invoiceNo" placeholder="Enter invoice no" wire:model='form.transaction.invoice_no'>
                                    <label for="invoiceNo">Invoice Number</label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="invoiceDate" wire:model='form.transaction.transaction_date'>
                                    <label for="invoiceDate">Date</label>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-floating">
                                    <select class="form-select" id="supplierOptions" wire:model='form.transaction.supplier_id'>
                                        <option value="">Select Supplier</option>
                                        @foreach ($options['supplier'] as $supp)
                                            <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="supplierOptions">Supplier</label>
                                </div>
                                @error('form.transaction.supplier_id')
                                    <span class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="note" placeholder="Enter your note transaction" wire:model='form.transaction.description'>
                                    <label for="note">Note</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12 py-3">
                    <h4 class="card-title mb-0 flex-grow-1 pb-3">List Item Order Transaction</h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width:1%">No</th>
                                    <th scope="col">Product</th>
                                    <th scope="col" style="width: 7%" class="text-center">Qty</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col" class="text-right">Price</th>
                                    <th scope="col" class="text-right" style="width: 20%">Total</th>
                                    <th scope="col" style="width: 90px;" class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($form['item_orders'] as $key => $order)
                                    <tr wire:key='{{ $key }}' class="align-middle">
                                        <form wire:submit.prevent='save({{ $key }})'>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <livewire:purchasing::components.search-product :keys="$key" :productname="$order['product_name']" :key="$key" />
                                                @error("form.item_orders.{$key}.product_id")
                                                    <span class="form-text text-danger" style="font-size: 8pt">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="form.item_orders.{{ $key }}.qty" id="qty{{ $key }}" style="text-align: center" wire:keydown.enter.prevent="save({{ $key }})">
                                                @error("form.item_orders.{$key}.qty")
                                                    <span class="form-text text-danger" style="font-size: 8pt">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm" wire:model='form.item_orders.{{ $key }}.unit_product_id'>
                                                    @foreach ($options['unit_product'][$key] as $unit)
                                                        <option value="{{ $unit->id }}">{{ $unit->unit->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error("form.item_orders.{$key}.unit_product_id")
                                                    <span class="form-text text-danger" style="font-size: 8pt">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="form.item_orders.{{ $key }}.price" style="text-align: right" wire:keydown.enter.prevent="save({{ $key }})">
                                                @error("form.item_orders.{$key}.price")
                                                    <span class="form-text text-danger" style="font-size: 8pt">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" @readonly(true) wire:model="form.item_orders.{{ $key }}.total_price" style="text-align: right">
                                                @error("form.item_orders.{$key}.total_price")
                                                    <span class="form-text text-danger" style="font-size: 8pt">{{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td class="text-end">
                                                @if (count($form['item_orders']) > 1 && !is_null($order['transaction_items']))
                                                    <button type="button" class="btn btn-danger btn-icon btn-sm waves-effect waves-light" wire:click="deleteItemOrder({{ $key }})"><i class="fa-sharp fa-solid fa-trash"></i></button>
                                                @endif
                                                <button class="btn @if (!is_null($order['transaction_items'])) btn-warning @else btn-primary @endif btn-icon btn-sm waves-effect waves-light" wire:click.prevent="save({{ $key }})">
                                                    @if (!is_null($order['transaction_items'])) <i class="fa-sharp fa-solid fa-pencil"></i> @else <i class="fa-sharp fa-solid fa-floppy-disk"></i> @endif
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('select-product', (event) => {
                document.getElementById("qty" + event.key).focus();
            });
        });
    </script>
</div>

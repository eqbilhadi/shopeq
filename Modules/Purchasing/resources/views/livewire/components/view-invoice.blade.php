<div>
    <div wire:ignore.self class="modal fade bs-example-modal-xl" id="view-invoice-modal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div wire:loading.remove>
            @if (!is_null($invoice))
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-header border-bottom-dashed p-4">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <img src="{{ asset('assets/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="17">
                                                <img src="{{ asset('assets/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="17">
                                                <div class="mt-sm-5 mt-4">
                                                    <h6 class="text-muted text-uppercase fw-semibold">Address</h6>
                                                    <p class="text-muted mb-1" id="address-details">California, United States</p>
                                                    <p class="text-muted mb-0" id="zip-code"><span>Zip-code:</span> 90201</p>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                <h6><span class="text-muted fw-normal">Supplier : </span><span id="legal-register-no">{{ $invoice->supplier->name }}</span></h6>
                                                <h6><span class="text-muted fw-normal">Phone : </span><span id="phone">{{ $invoice->supplier->phone }}</span></h6>
                                                <h6 class="mb-0"><span class="text-muted fw-normal">Address : </span><span id="address">{{ $invoice->supplier->address }}</span></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-header-->
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <div class="col-lg-4 col-4">
                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Invoice No</p>
                                                <h5 class="fs-14 mb-0">{{ $invoice->invoice_no ?? '' }}</h5>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4 col-4">
                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{ $invoice->transaction_date?->format('d M, Y') }}</span> <small class="text-muted" id="invoice-time">{{ $invoice->created_at->format('H:i') }}</small></h5>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4 col-4">
                                                <p class="text-muted mb-2 text-uppercase fw-semibold">Total Amount</p>
                                                <h5 class="fs-14 mb-0">Rp. <span id="total-amount">{{ number_format($invoice->orderItems?->sum('total_price'), 2, ',', '.') }}</span></h5>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="card-body p-4">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th scope="col" style="width: 50px;">#</th>
                                                        <th scope="col">Product Details</th>
                                                        <th scope="col">Rate</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col" class="text-end">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="products-list">
                                                    @foreach ($invoice->orderItems as $order)
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td class="text-start">
                                                                <span class="fw-medium">{{ $order->mstProduct->name }}</span>
                                                            </td>
                                                            <td>Rp. {{ number_format($order->price, 0, ',', '.') }}</td>
                                                            <td>{{ $order->qty }}</td>
                                                            <td class="text-end">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table><!--end table-->
                                        </div>
                                        <div class="border-top border-top-dashed mt-2">
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                <tbody>
                                                    <tr>
                                                        <td>Sub Total</td>
                                                        <td class="text-end">{{ number_format($invoice->orderItems?->sum('total_price'), 2, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Discount</td>
                                                        <td class="text-end">0</td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed fs-15">
                                                        <th scope="row">Total Amount</th>
                                                        <th class="text-end">{{ number_format($invoice->orderItems?->sum('total_price'), 2, ',', '.') }}</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <div class="hstack gap-2 justify-content-end d-print-none mt-5">
                                            <a href="javascript:void(0);" class="btn btn-ghost-primary fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                            <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div wire:loading.flex>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

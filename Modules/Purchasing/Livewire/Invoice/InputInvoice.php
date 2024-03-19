<?php

namespace Modules\Purchasing\Livewire\Invoice;

use Exception;
use Illuminate\Support\Arr;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstSupplier;
use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\Services\Invoice\GenerateInvoiceNumber;
use Illuminate\Support\Str;
use Modules\Master\traits\WithFlashMessage;
use Modules\Purchasing\Services\Invoice\Registration\InvoiceRegistration;

class InputInvoice extends Component
{
    use WithFlashMessage;

    public ?Transaction $transaction = null;
    public string $idProduct;

    public array $form = [
        'transaction' => [
            'invoice_no' => '',
            'transaction_date' => '',
            'type' => 'TRANSACTION',
            'status' => 'IN',
            'supplier_id' => '',
            'description' => '',
        ],
        'item_orders' => [
            [
                'status' => 'IN',
                'product_id' => '',
                'product_name' => '',
                'unit_product_id' => null,
                'qty' => '',
                'price' => 0,
                'total_price' => 0,
                'transaction_items' => null,
            ],
        ]
    ];

    public array $options = [
        "unit_product" => [[]],
    ];

    public function mount()
    {
        $this->options['supplier'] = MstSupplier::all();
        $userId = auth()->user()->id;

        if (Transaction::hasDraft($userId)) {
            unset($this->form['item_orders'][0]);
            $this->transaction = Transaction::draft()->where('created_by', $userId)->first();
            $this->form['transaction']['invoice_no'] = $this->transaction->invoice_no;
            $this->form['transaction']['transaction_date'] = $this->transaction->transaction_date;
            $this->form['transaction']['supplier_id'] = $this->transaction->supplier_id;

            foreach ($this->transaction->orderItems as $key => $value) {
                $form = [
                    'status' => 'IN',
                    'product_id' => $value->product_id,
                    'product_name' => $value->mstProduct->name,
                    'price' => $value->price,
                    'qty' => $value->qty,
                    'total_price' => $value->total_price,
                    'unit_product_id' => $value->unit_product_id,
                    'transaction_items' => $value
                ];
                array_push($this->form['item_orders'], $form);
                array_push($this->options['unit_product'], $value->mstProduct->units);
            }

            $this->addFormItemOrder();
        } else {
            $this->form['transaction']['invoice_no'] = (new GenerateInvoiceNumber("IN"))->create();
            $this->form['transaction']['transaction_date'] = date('Y-m-d');
        }
    }


    public function save($key)
    {
        $this->validate(
            [
                'form.transaction.supplier_id' => 'required',
                'form.item_orders.' . $key . '.product_id' => 'required',
                'form.item_orders.' . $key . '.unit_product_id' => 'required',
                'form.item_orders.' . $key . '.qty' => 'required|numeric',
                'form.item_orders.' . $key . '.price' => 'required|numeric',
                'form.item_orders.' . $key . '.total_price' => 'required|numeric',
            ],
            [],
            [
                'form.transaction.supplier_id' => 'supplier',
                'form.item_orders.' . $key . '.product_id' => 'product',
                'form.item_orders.' . $key . '.unit_product_id' => 'unit product',
                'form.item_orders.' . $key . '.qty' => 'qty',
                'form.item_orders.' . $key . '.price' => 'price',
                'form.item_orders.' . $key . '.total_price' => 'total price',
            ]
        );


        $params['transaction'] = $this->form['transaction'];
        $params['item_orders'] = $this->form['item_orders'][$key];

        try {
            if (is_null($this->form['item_orders'][$key]['transaction_items'])) {
                $this->flashSuccess('Successfully saved');
                $this->addFormItemOrder();
            } else {
                $this->flashSuccess('Successfully updated');
            }

            $lastInsert = (new InvoiceRegistration($this->transaction, $this->form['item_orders'][$key]['transaction_items'], $params))->handle();
            $this->form['item_orders'][$key]['transaction_items'] = $lastInsert->itemOrder;
            $this->transaction = $lastInsert->transaction;
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    public function deleteItemOrder($key)
    {
        $itemOrder = $this->form['item_orders'][$key]['transaction_items'];

        unset($this->form['item_orders'][$key]);
        unset($this->options['unit_product'][$key]);
        $itemOrder->delete();

        $this->flashSuccess('Successfully deleted');
    }

    public function cancelInput()
    {
        if (!is_null($this->transaction)) {
            $this->transaction->delete();
            $this->transaction = null;
            $this->form['transaction']['supplier_id'] = '';
            foreach ($this->form['item_orders'] as $key => $value) {
                if(!is_null($value['transaction_items'])) {
                    unset($this->form['item_orders'][$key]);
                }
            }
        }
    }

    public function finishInput()
    {
        $this->transaction->update(['is_draft' => 0]);

        $this->flashSuccess("Invoice successfully saved");
        return $this->redirect(route('purchasing.invoice.index'), navigate: true);
    }

    #[Computed]
    public function product()
    {
        return MstProduct::with("units.unit")->find($this->idProduct);
    }

    #[On('select-product')]
    public function selectProduct($productId, $key)
    {
        $this->idProduct = $productId;
        $this->setItemOrder($key);
        $this->registerOptionsUnitProduct($key);

        $this->dispatch('set-qty-focus', key: $key);
    }

    #[On('reset-product')]
    public function resetProduct($key)
    {
        $this->resetFormProduct($key);
    }

    public function setItemOrder($key)
    {
        $product = $this->product;

        $this->form['item_orders'][$key]['product_id'] = $product->id;
        $this->form['item_orders'][$key]['product_name'] = $product->name;
        $this->form['item_orders'][$key]['price'] = $product->purchase_price;
        $this->form['item_orders'][$key]['qty'] = 1;
        $this->form['item_orders'][$key]['total_price'] = $product->purchase_price;
        $this->form['item_orders'][$key]['unit_product_id'] = $this->product->units->where('is_main_unit', true)->pluck('id')->first();
    }

    public function registerOptionsUnitProduct($key)
    {
        $product = $this->product;

        $this->options['unit_product'][$key] = $product->units;
    }

    public function resetFormProduct($key)
    {
        $this->form['item_orders'][$key]['product_id'] = "";
        $this->form['item_orders'][$key]['product_name'] = "";
        $this->form['item_orders'][$key]['unit_product_id'] = "";
        $this->form['item_orders'][$key]['qty'] = "";
        $this->form['item_orders'][$key]['price'] = 0;
        $this->form['item_orders'][$key]['total_price'] = 0;
        $this->options['unit_product'][$key] = [];
    }

    public function updatedForm($value, $key)
    {
        $parts = explode('.', $key);
        if (Str::contains($key, "qty")) {
            $price = Arr::get($this->form['item_orders'][$parts[1]], 'price');
            $value = $value == null ? 0 : $value;
            $total = $price * $value;

            $this->form['item_orders'][$parts[1]]['total_price'] = $total;
        }
        if (Str::contains($key, "price")) {
            $qty = Arr::get($this->form['item_orders'][$parts[1]], 'qty');
            $value = $value == null ? 0 : $value;
            $total = $qty * $value;

            $this->form['item_orders'][$parts[1]]['total_price'] = $total;
        }
    }

    public function addFormItemOrder()
    {
        $form = [
            'status' => 'IN',
            'product_id' => '',
            'product_name' => '',
            'unit_product_id' => null,
            'qty' => '',
            'price' => 0,
            'total_price' => 0,
            'transaction_items' => null,
        ];

        array_push($this->form['item_orders'], $form);
        array_push($this->options['unit_product'], []);
    }

    public function render()
    {
        return view('purchasing::livewire.invoice.input-invoice');
    }
}

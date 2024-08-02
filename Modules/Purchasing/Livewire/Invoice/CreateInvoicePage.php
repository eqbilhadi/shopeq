<?php

namespace Modules\Purchasing\Livewire\Invoice;

use Exception;
use Illuminate\Support\Arr;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstSupplier;
use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\traits\WithFlashMessage;
use Modules\Purchasing\Services\Invoice\GenerateInvoiceNumber;
use Modules\Purchasing\Livewire\Validations\CreatePurchasingInvoiceValidations;
use Modules\Purchasing\Services\Invoice\Registration\OrderItemRegistration;

class CreateInvoicePage extends Component
{
    use WithFlashMessage, CreatePurchasingInvoiceValidations;

    public ?Transaction $transaction = null;

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
                'transaction_item' => null,
                'mst_product' => null
            ],
        ]
    ];

    public array $options = [
        'unit_product' => []
    ];

    public function mount()
    {
        $userId = auth()->user()->id;
        $this->options['supplier'] = MstSupplier::all()->toArray();

        if (Transaction::hasDraft($userId)) {
            $this->transaction = Transaction::where('status', 'IN')
                ->with('orderItems.mstProduct.units')
                ->getDraft($userId);

            $this->setFormTransaction($this->transaction);
            $this->setFormOrderTransaction($this->transaction->orderItems);
            $this->addFormOrderItem();
        } else {
            $this->form['transaction']['invoice_no'] = (new GenerateInvoiceNumber("IN"))->create();
            $this->form['transaction']['transaction_date'] = date('Y-m-d');

            array_push($this->options['unit_product'], []);
        }
    }

    protected function setFormTransaction($transaction): void
    {
        $this->form['transaction']['invoice_no'] = $transaction->invoice_no;
        $this->form['transaction']['transaction_date'] = $transaction->transaction_date->format('Y-m-d');
        $this->form['transaction']['supplier_id'] = $transaction->supplier_id;
        $this->form['transaction']['description'] = $transaction->description;
    }

    protected function setFormOrderTransaction($orders): void
    {
        array_splice($this->form['item_orders'], 0, 1);

        foreach ($orders as $key => $order) {
            $formOrder = [
                'status' => 'IN',
                'product_id' => $order->product_id,
                'product_name' => $order->mstProduct->name,
                'price' => number_format($order->price, 0, '.', '.'),
                'qty' => $order->qty,
                'total_price' => number_format($order->total_price, 0, '.', '.'),
                'unit_product_id' => $order->unit_product_id,
                'transaction_item' => $order,
                'mst_product' => $order->mstProduct
            ];

            array_push($this->form['item_orders'], $formOrder);
            array_push($this->options['unit_product'], $order->mstProduct->units);
        }
    }

    #[On('select-product')]
    public function selectProduct($productId, $key)
    {
        $product = MstProduct::with('units.unit')->find($productId);

        $this->setOrderItem($product, $key);
        $this->registerOptionsUnitProduct($product, $key);
    }

    #[On('reset-product')]
    public function resetProduct($key)
    {
        $this->resetFormProduct($key);
    }

    protected function setOrderItem($product, $key)
    {
        $this->form['item_orders'][$key]['product_id'] = $product->id;
        $this->form['item_orders'][$key]['name'] = $product->name;
        $this->form['item_orders'][$key]['price'] = number_format($product->units->where('is_main_unit', true)->pluck('purchase_price')->first(), 0, '.', '.');
        $this->form['item_orders'][$key]['qty'] = 1;
        $this->form['item_orders'][$key]['total_price'] = number_format($product->units->where('is_main_unit', true)->pluck('purchase_price')->first(), 0, '.', '.');
        $this->form['item_orders'][$key]['unit_product_id'] = $product->units->where('is_main_unit', true)->pluck('id')->first();
        $this->form['item_orders'][$key]['mst_product'] = $product;
    }

    public function registerOptionsUnitProduct($product, $key)
    {
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
        if (Str::contains($key, 'unit_product_id')) {
            $product = $this->form['item_orders'][$parts[1]]['mst_product'];
            $this->form['item_orders'][$parts[1]]['price'] =  number_format($product->units->where('id', $value)->pluck('purchase_price')->first(), 0, '.', '.');
            
            $price = preg_replace("/[^0-9]/", "", $this->form['item_orders'][$parts[1]]['price']);
            $qty = $this->form['item_orders'][$parts[1]]['qty'];
            $total = intval($price) * intval($qty);
            
            $this->form['item_orders'][$parts[1]]['total_price'] = number_format($total, 0, '.', '.');
        }
        if (Str::contains($key, 'qty')) {
            $product = $this->form['item_orders'][$parts[1]]['mst_product'];
            $price = Arr::get($this->form['item_orders'][$parts[1]], 'price');
            $price = preg_replace("/[^0-9]/", "", $price);
            
            $total = intval($price) * intval($value);
            $this->form['item_orders'][$parts[1]]['total_price'] = number_format($total, 0, '.', '.');
        }
        if (Str::contains($key, 'price')) {
            $product = $this->form['item_orders'][$parts[1]]['mst_product'];
            $qty = Arr::get($this->form['item_orders'][$parts[1]], 'qty');
            $value = preg_replace("/[^0-9]/", "", $value);

            $total = intval($qty) * intval($value);
            $this->form['item_orders'][$parts[1]]['total_price'] = number_format($total, 0, '.', '.');
        }
    }

    public function saveOrderItem($key)
    {
        $this->validationsItemOrder($key);

        try {
            if (is_null($this->form['item_orders'][$key]['transaction_item'])) {
                $this->flashSuccess('Successfully added item order');
                $this->addFormOrderItem();
            } else {
                $this->flashSuccess('Successfully updated item order');
            }

            $lastInsert = (new OrderItemRegistration($this->transaction, $this->form['item_orders'][$key]))->handle();
            $this->form['item_orders'][$key]['transaction_item'] = $lastInsert->transactionItem;
            $this->transaction = $lastInsert->transaction;
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    public function deleteOrderItem($key)
    {
        $itemOrder = $this->form['item_orders'][$key]['transaction_item'];
        $itemOrder->delete();

        unset($this->form['item_orders'][$key]);
        unset($this->options['unit_product'][$key]);

        $this->flashSuccess('Successfully deleted item order');
    }

    public function finishCreateInvoice()
    {
        $this->validationsInvoice();

        try {
            $this->transaction->update([
                'invoice_no' => $this->form['transaction']['invoice_no'],
                'transaction_date' => $this->form['transaction']['transaction_date'],
                'description' => $this->form['transaction']['description'],
                'supplier_id' => $this->form['transaction']['supplier_id'],
                'is_draft' => 0
            ]);

            return $this->redirect(route('purchasing.invoice.index'));
        } catch (Exception $exception) {
            $this->flashError($exception);
        }
    }

    public function cancelInput()
    {
        if (!is_null($this->transaction)) {
            $this->transaction->delete();
            $this->transaction = null;

            foreach ($this->form['item_orders'] as $key => $value) {
                if (!is_null($value['transaction_item'])) {
                    unset($this->form['item_orders'][$key]);
                    unset($this->options['unit_product'][$key]);
                }
            }
        }
    }

    public function addFormOrderItem()
    {
        $form = [
            'status' => 'IN',
            'product_id' => '',
            'product_name' => '',
            'unit_product_id' => null,
            'qty' => '',
            'price' => 0,
            'total_price' => 0,
            'transaction_item' => null,
            'mst_product' => null
        ];

        array_push($this->form['item_orders'], $form);
        array_push($this->options['unit_product'], []);
    }

    public function render()
    {
        return view('purchasing::livewire.invoice.create-invoice-page');
    }
}

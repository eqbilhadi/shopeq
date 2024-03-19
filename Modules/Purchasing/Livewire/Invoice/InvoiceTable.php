<?php

namespace Modules\Purchasing\Livewire\Invoice;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Purchasing\app\Models\Transaction;

class InvoiceTable extends Component
{
    public array $filter = [
        'startDate' => '',
        'endDate' => '',
        'search' => ''
    ];

    public function mount()
    {
        $this->filter['startDate'] = date('Y-m-d');
        $this->filter['endDate'] = date('Y-m-d');
    }

    #[Computed]
    public function invoices()
    {
        return Transaction::completed()
            ->filter($this->filter)
            ->paginate(15);
    }

    public function render()
    {
        return view('purchasing::livewire.invoice.invoice-table', [
            'results' => $this->invoices
        ]);
    }
}

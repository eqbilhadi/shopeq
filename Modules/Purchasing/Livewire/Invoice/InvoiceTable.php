<?php

namespace Modules\Purchasing\Livewire\Invoice;

use Livewire\Attributes\Computed;
use Livewire\Component;
use Modules\Master\traits\WithFlashMessage;
use Modules\Purchasing\app\Models\Transaction;

class InvoiceTable extends Component
{
    use WithFlashMessage;

    public array $filter = [
        'startDate' => '',
        'endDate' => '',
        'search' => ''
    ];

    public function mount()
    {
        $this->filter['startDate'] = now()->startOfMonth()->format('Y-m-d');
        $this->filter['endDate'] = date('Y-m-d');
    }

    #[Computed]
    public function invoices()
    {
        return Transaction::completed()
            ->filter($this->filter)
            ->latest()
            ->paginate(15);
    }

    public function delete($id)
    {
        Transaction::destroy($id);

        $this->flashSuccess('Successfully deleted');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('purchasing::livewire.invoice.invoice-table', [
            'results' => $this->invoices
        ]);
    }
}

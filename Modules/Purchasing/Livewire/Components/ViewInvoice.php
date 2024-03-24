<?php

namespace Modules\Purchasing\Livewire\Components;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Purchasing\app\Models\Transaction;

class ViewInvoice extends Component
{
    public string $id = '';
    public bool $readyToLoad = false;

    #[On('init-open')]
    public function initOpen($id)
    {
        $this->readyToLoad = true;
        $this->id = $id;
    }

    #[Computed()]
    public function invoice()
    {
        return Transaction::with(['orderItems', 'supplier'])->find($this->id);
    }

    public function render()
    {
        return view('purchasing::livewire.components.view-invoice', [
            'invoice' => $this->invoice
        ]);
    }
}

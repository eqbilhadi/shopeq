<?php

namespace Modules\Purchasing\Services\Invoice;

use Illuminate\Support\Carbon;
use Modules\Purchasing\app\Models\Transaction;

class GenerateInvoiceNumber
{
    protected string $prefix = 'INV';

    protected Carbon $dateNow;

    protected string $type;

    public function __construct(string $type)
    {
        $this->dateNow = Carbon::now();

        $this->type = $type;
    }

    public function getFormattedDate(): string
    {
        return $this->dateNow->format('Ymd');
    }

    public function create(): string
    {
        return $this->generate($this->getLastRegisteredNumber());
    }

    protected function generate(?string $number = null): string
    {
        // generate formatted number
        $freshNumber = $this->prefix . $this->type . $this->getFormattedDate() . str_pad($number, 5, '0', STR_PAD_LEFT);

        // check if number already exist
        if (Transaction::hasExistNumber($freshNumber)) {
            return $this->generate($number + 1);
        }
        
        // return fresh number
        return $freshNumber;
    }
    
    protected function getLastRegisteredNumber()
    {
        return Transaction::getLastInvoiceNumber($this->getFormattedDate(), $this->type);
    }

}
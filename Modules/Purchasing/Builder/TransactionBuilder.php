<?php

namespace Modules\Purchasing\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TransactionBuilder extends Builder
{
    public function filter(array $filters = []): self
    {
        $this->when($filters['search'] ?? null, function ($query, $searchText) {
            $query->where('invoice_no', 'like', $searchText . '%');
            $query->whereHas('supplier', fn ($query) => $query->whereName($searchText));
        });

        $this->whereBetween('transaction_date', [$filters['startDate'], $filters['endDate']]);

        return $this;
    }

    public function transaction()
    {
        $this->where('type', 'TRANSACTION');

        return $this;
    }

    public function opname()
    {
        $this->where('type', 'OPNAME');

        return $this;
    }

    public function retur()
    {
        $this->where('type', 'RETUR');

        return $this;
    }

    public function hasDraft($user_id): bool
    {
        $this->where('is_draft', true)->where('created_by', $user_id);

        return $this->exists();
    }

    public function draft()
    {
        $this->where('is_draft', true);

        return $this;
    }

    public function completed()
    {
        $this->where('is_draft', false);

        return $this;
    }

    public function getLastInvoiceNumber($dateNow, $type)
    {
        $lastNumberInvoice = $this->whereType($type)
            ->whereTransactionDate($dateNow)
            ->latest()
            ->first();

        return $lastNumberInvoice ? intval(substr($lastNumberInvoice->invoice_no, -5)) + 1 : 1;
    }

    public function hasExistNumber(string $invoiceNo): bool
    {
        return $this
            ->where('invoice_no', $invoiceNo)
            ->exists();
    }
}

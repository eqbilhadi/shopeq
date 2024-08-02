<?php

namespace Modules\Purchasing\Services\Invoice\Destroy;

use Modules\Purchasing\app\Models\Transaction;
use Modules\Purchasing\Services\Invoice\Registration\RegistrationService;

class InvoiceDestroy extends RegistrationService
{
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function save(): void
    {
        if(is_array($this->id)) {
            Transaction::destroy($this->id);
        } else {
            Transaction::find($this->id)->delete();
        }
    }
}

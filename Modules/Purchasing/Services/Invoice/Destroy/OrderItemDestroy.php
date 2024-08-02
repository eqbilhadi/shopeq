<?php

namespace Modules\Purchasing\Services\Invoice\Destroy;

use Modules\Purchasing\app\Models\TransactionItem;
use Modules\Purchasing\Services\Invoice\Registration\RegistrationService;

class OrderItemDestroy extends RegistrationService
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
            TransactionItem::destroy($this->id);
        } else {
            TransactionItem::find($this->id)->delete();
        }
    }
}

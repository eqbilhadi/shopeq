<?php

namespace Modules\Master\Services\Supplier\Destroy;

use Modules\Master\app\Models\MstSupplier;
use Modules\Master\Services\Supplier\Registration\RegistrationService;

class SupplierDestroy extends RegistrationService
{
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Save action
     *
     * @return void
     */
    public function save(): void
    {
        if(is_array($this->id)) {
            MstSupplier::destroy($this->id);
        } else {
            MstSupplier::find($this->id)->delete();
        }
    }
}

<?php

namespace Modules\Master\Services\Customer\Destroy;

use Modules\Master\app\Models\MstCustomer;
use Modules\Master\Services\Customer\Registration\RegistrationService;

class CustomerDestroy extends RegistrationService
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
            MstCustomer::destroy($this->id);
        } else {
            MstCustomer::find($this->id)->delete();
        }
    }
}

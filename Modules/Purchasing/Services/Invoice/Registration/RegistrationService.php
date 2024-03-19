<?php

namespace Modules\Purchasing\Services\Invoice\Registration;

use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class RegistrationService
{
    public function handle()
    {
        // start transaction
        DB::beginTransaction();

        try {
            // handle register new applicant
            $saved = $this->save();

            // commit
            DB::commit();

            return $saved;
        } catch (Throwable $exception) {
            // rollback
            DB::rollBack();

            // throw error
            throw new Exception($exception->getMessage());
        }
    }

    public abstract function save();
}

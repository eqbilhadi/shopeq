<?php

namespace Modules\Master\Services\Supplier\Registration;

use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class RegistrationService
{
    public function handle(): void
    {
        // start transaction
        DB::beginTransaction();

        try {
            // handle register new applicant
            $this->save();

            // commit
            DB::commit();
        } catch (Throwable $exception) {
            // rollback
            DB::rollBack();

            // throw error
            throw new Exception($exception->getMessage());
        }
    }

    public abstract function save(): void;
}

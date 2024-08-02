<?php

namespace Modules\Purchasing\traits;

trait WithFlashMessage
{

    public function flashError(string $message): void
    {
        flash()->options(['timeout' => 1800])->addError($message);
    }

    public function flashSuccess(string $message): void
    {
        flash()->options(['timeout' => 1800])->addSuccess($message);
    }

}

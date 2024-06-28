<?php

namespace Modules\Master\Enums;

use Modules\Master\traits\EnumToArray;

enum StatusEnum: string
{
    use EnumToArray;

    case published = 'Published';
    case draft = 'Draft';
}

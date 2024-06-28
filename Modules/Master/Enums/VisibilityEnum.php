<?php

namespace Modules\Master\Enums;

use Modules\Master\traits\EnumToArray;

enum VisibilityEnum: string
{
    use EnumToArray;

    case public = 'Public';
    case hidden = 'Hidden';
}

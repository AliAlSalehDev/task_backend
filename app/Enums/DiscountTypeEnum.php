<?php

namespace App\Enums;

use App\Traits\Core\EnumOperation;

enum DiscountTypeEnum: string
{
    use EnumOperation;
    case fixed = 'Fixed Discount';

    case percentage = 'Percentage Discount';
}

<?php
namespace App\Model\Enum;

use MyCLabs\Enum\Enum;

final class Notify extends Enum
{
    const ENABLED = 0;
    const DISABLED = 1;
    const MAINTENANCE = 2;
}

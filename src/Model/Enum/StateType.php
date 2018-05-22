<?php

namespace App\Model\Enum;

use MyCLabs\Enum\Enum;

final class StateType extends Enum
{
    const ENABLE = 1;
    const RUNNING = 2;
    const DISABLED = 3;
    const STOPPED = 4;
    const TERMINATED = 5;
}

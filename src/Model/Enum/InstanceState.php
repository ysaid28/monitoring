<?php

namespace App\Model\Enum;

use MyCLabs\Enum\Enum;

final class InstanceState extends Enum
{
    const UNKNOWN = 'unknown';
    const ENABLE = 'enable';
    const PENDING = 'pending';
    const RUNNING = 'running';
    const DISABLED = 'disabled';
    const STOPPED = 'stopped';
    const TERMINATED = 'terminated';
    const FAILED = 'failed';
    const REDIRECTION = 'redirection';
    const CLIENTERROR = 'client errors';
    const SERVERERROR = 'server error';
}

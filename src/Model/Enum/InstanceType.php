<?php

namespace App\Model\Enum;

use MyCLabs\Enum\Enum;

final class InstanceType extends Enum
{
    const EC2 = "ec2";
    const RDS = "rds";
    const OTHER = "other_instance";
}

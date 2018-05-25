<?php
namespace App\Entity;

use App\Model\Enum\InstanceType;
use App\Model\OtherInstanceInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OtherInstanceRepository")
 * @ORM\Table(name="other_instance")
 */
class OtherInstance extends Instance implements OtherInstanceInterface
{
      /**
     * RDS constructor.
     */
    public function __construct()
    {
        parent::__construct(InstanceType::OTHER);
    }
}

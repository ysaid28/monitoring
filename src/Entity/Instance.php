<?php

namespace App\Entity;

use App\Entity\Traits\SortableEntity;
use App\Entity\Traits\StateEntity;
use App\Model\Enum\InstanceType;
use App\Model\InstanceInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *     "ec2"       = "App\Entity\EC2",
 *     "rds"       = "App\Entity\RDS",
 *     "other_instance"       = "App\Entity\OtherInstance"
 * })
 * */
abstract class Instance implements InstanceInterface
{
    use SortableEntity;
    use StateEntity;
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * Instance constructor.
     * @param string $instanceType
     */
    public function __construct(string $instanceType)
    {
        if (!InstanceType::isValid($instanceType)) {
            throw new \UnexpectedValueException("Value '$instanceType' is not a valid Content Type");
        }
        $this->type = $instanceType;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return Instance
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $type
     * @return Instance
     */
    public function setType(?string $type): Instance
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}

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
 * @ORM\DiscriminatorColumn(name="instance_type", type="string", length=20)
 * @ORM\DiscriminatorMap({
 *     "ec2"       = "App\Entity\EC2",
 *     "ec2"       = "App\Entity\RDS",
 *     "other_instance"       = "App\Entity\OtherInstance",
 * })
 * */
abstract class Instance implements InstanceInterface
{
    use SortableEntity;
    use StateEntity;
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     */
    private $instanceType;

    /**
     * Instance constructor.
     * @param string $instanceType
     */
    public function __construct(string $instanceType)
    {
        if (!InstanceType::isValid($instanceType)) {
            throw new \UnexpectedValueException("Value '$instanceType' is not a valid Content Type");
        }
        $this->instanceType = $instanceType;
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
     * @param string $instanceType
     * @return Instance
     */
    public function setInstanceType(string $instanceType): Instance
    {
        $this->instanceType = $instanceType;
        return $this;
    }

    /**
     * @return string
     */
    public function getInstanceType(): string
    {
        return $this->instanceType;
    }
}

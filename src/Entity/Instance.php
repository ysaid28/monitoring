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
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=true)
     */
    private $publicId;

    /**
     * @var string
     *
     * @ORM\Column(name="private_id", type="string", length=255, nullable=true)
     */
    private $privateId;

    /**
     * @var string
     *
     * @ORM\Column(name="host_name", type="string", length=255, nullable=true)
     */
    private $hostName;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled_ssl", type="boolean",  nullable=true)
     */
    private $enabledSSL = false;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="instances")
     *
     */
    private $project;


    /**
     * Instance constructor.
     * @param string $instanceType
     */
    public function __construct(string $instanceType)
    {
        if (!InstanceType::isValid($instanceType)) {
            throw new \UnexpectedValueException("Value '$instanceType' is not a valid Instance Type");
        }
        $this->type = $instanceType;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): ?int
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

    /**
     * @return string
     */
    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    /**
     * @param string $publicId
     * @return Instance
     */
    public function setPublicId(?string $publicId): self
    {
        $this->publicId = $publicId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateId(): ?string
    {
        return $this->privateId;
    }

    /**
     * @param string $privateId
     * @return Instance
     */
    public function setPrivateId(?string $privateId): self
    {
        $this->privateId = $privateId;
        return $this;
    }

    /**
     * @return string
     */
    public function getHostName(): ?string
    {
        return $this->hostName;
    }

    /**
     * @param string $hostName
     * @return Instance
     */
    public function setHostName(?string $hostName): self
    {
        $this->hostName = $hostName;
        return $this;
    }


    /**
     * @return bool
     */
    public function isEnabledSSL(): ?bool
    {
        return $this->enabledSSL;
    }

    /**
     * @param bool $enabledSSL
     * @return Instance
     */
    public function setEnabledSSL(?bool $enabledSSL): self
    {
        $this->enabledSSL = $enabledSSL !== null ? $enabledSSL : false;
        return $this;
    }

    public function getEnabledSSL(): ?bool
    {
        return $this->enabledSSL;
    }

    /**
     * @return Project|null
     */
    public function getProject(): ?Project
    {
        return $this->project;
    }

    /**
     * @param Project|null $project
     * @return Instance
     */
    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }
}

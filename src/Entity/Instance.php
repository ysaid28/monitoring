<?php

namespace App\Entity;

use App\Entity\Traits\EnabledEntity;
use App\Entity\Traits\NotificationEntity;
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
    use EnabledEntity;
    use TimestampableEntity;
    use NotificationEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     *
     * @ORM\Column(name="public_id", type="string", length=255, nullable=true)
     */
    protected $publicId;

    /**
     * @var string
     *
     * @ORM\Column(name="private_id", type="string", length=255, nullable=true)
     */
    protected $privateId;

    /**
     * @var string
     *
     * @ORM\Column(name="host_name", type="string", length=255, nullable=true)
     */
    protected $hostName;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled_ssl", type="boolean",  nullable=true)
     */
    protected $enabledSSL = false;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="instances")
     *
     */
    protected $project;


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
     * @return int|null
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
    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return null|string
     */
    public function getPublicId(): ?string
    {
        return $this->publicId;
    }

    /**
     * @param null|string $publicId
     * @return Instance
     */
    public function setPublicId(?string $publicId): self
    {
        $this->publicId = $publicId;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getPrivateId(): ?string
    {
        return $this->privateId;
    }
    
    /**
     * @param null|string $privateId
     * @return Instance
     */
    public function setPrivateId(?string $privateId): self
    {
        $this->privateId = $privateId;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getHostName(): ?string
    {
        return $this->hostName;
    }
    
    /**
     * @param null|string $hostName
     * @return Instance
     */
    public function setHostName(?string $hostName): self
    {
        $this->hostName = $hostName;
        return $this;
    }
    
    /**
     * @return bool|null
     */
    public function isEnabledSSL(): ?bool
    {
        return $this->enabledSSL;
    }
    
    /**
     * @param bool|null $enabledSSL
     * @return Instance
     */
    public function setEnabledSSL(?bool $enabledSSL): self
    {
        $this->enabledSSL = $enabledSSL !== null ? $enabledSSL : false;
        return $this;
    }

    /**
     * @return bool|null
     */
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

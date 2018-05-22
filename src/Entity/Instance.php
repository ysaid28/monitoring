<?php

namespace App\Entity;

use App\Entity\Traits\SortableEntity;
use App\Entity\Traits\StateEntity;
use App\Model\InstanceInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstanceRepository")
 */
class Instance implements InstanceInterface
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
    private $arn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;


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
    public function getArn(): ?string
    {
        return $this->arn;
    }

    /**
     * @param null|string $arn
     * @return Instance
     */
    public function setArn(?string $arn): self
    {
        $this->arn = $arn;

        return $this;
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
}

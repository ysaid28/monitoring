<?php

namespace App\Entity;

use App\Entity\Traits\SortableEntity;
use Doctrine\ORM\Mapping as ORM;
use App\Model\ProjectInterface;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project implements ProjectInterface
{
    use SortableEntity;
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
     * Project constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int | null
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
     * @return Project
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubnetRepository")
 */
class Subnet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="subnet_id", length=255, nullable=true)
     */
    private $subnetId;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\EC2",
     *     mappedBy="subnet",
     *     cascade={"persist"}
     *     )
     */
    private $ec2s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ec2s = new ArrayCollection();
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
    public function getSubnetId(): ?string
    {
        return $this->subnetId;
    }

    /**
     * @param null|string $SubnetId
     * @return Subnet
     */
    public function setSubnetId(?string $SubnetId): self
    {
        $this->subnetId = $SubnetId;

        return $this;
    }


    /**
     * @return Collection
     */
    public function getEc2s(): ?Collection
    {
        return $this->ec2s;
    }

    /**
     * @param EC2 $ec2
     * @return Subnet
     */
    public function addEc2s(EC2 $ec2): self
    {
        $this->ec2s[] = $ec2;

        return $this;
    }

    /**
     * Remove result
     *
     * @param EC2 $ec2
     */
    public function removeResult(EC2 $ec2): void
    {
        $this->ec2s->removeElement($ec2);
    }
}

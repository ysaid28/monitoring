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
     * Subnet constructor.
     */
    public function __construct()
    {
        $this->ec2s = new ArrayCollection();
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
    public function getSubnetId(): ?string
    {
        return $this->subnetId;
    }

    /**
     * @param null|string $subnetId
     * @return Subnet
     */
    public function setSubnetId(?string $subnetId): self
    {
        $this->subnetId = $subnetId;

        return $this;
    }

    /**
     * @return Collection|EC2[]
     */
    public function getEc2s(): Collection
    {
        return $this->ec2s;
    }

    /**
     * @param EC2 $ec2
     * @return Subnet
     */
    public function addEc2(EC2 $ec2): self
    {
        if (!$this->ec2s->contains($ec2)) {
            $this->ec2s[] = $ec2;
            $ec2->setSubnet($this);
        }

        return $this;
    }

    /**
     * @param EC2 $ec2
     * @return Subnet
     */
    public function removeEc2(EC2 $ec2): self
    {
        if ($this->ec2s->contains($ec2)) {
            $this->ec2s->removeElement($ec2);
            // set the owning side to null (unless already changed)
            if ($ec2->getSubnet() === $this) {
                $ec2->setSubnet(null);
            }
        }

        return $this;
    }
    
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VPCRepository")
 */
class VPC
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vpcId;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\EC2",
     *     mappedBy="vpc",
     *     cascade={"persist"}
     *     )
     */
    private $ec2s;

    /**
     * VPC constructor.
     */
    public function __construct()
    {
        $this->ec2s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getVpcId(): ?string
    {
        return $this->vpcId;
    }

    /**
     * @param string $vpcId
     * @return VPC
     */
    public function setVpcId(string $vpcId): self
    {
        $this->vpcId = $vpcId;

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
     * @return VPC
     */
    public function addEc2(EC2 $ec2): self
    {
        if (!$this->ec2s->contains($ec2)) {
            $this->ec2s[] = $ec2;
            $ec2->setVpc($this);
        }

        return $this;
    }

    /**
     * @param EC2 $ec2
     * @return VPC
     */
    public function removeEc2(EC2 $ec2): self
    {
        if ($this->ec2s->contains($ec2)) {
            $this->ec2s->removeElement($ec2);
            // set the owning side to null (unless already changed)
            if ($ec2->getVpc() === $this) {
                $ec2->setVpc(null);
            }
        }

        return $this;
    }

}

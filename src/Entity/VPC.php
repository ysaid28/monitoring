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

    public function getVpcId(): ?string
    {
        return $this->vpcId;
    }

    public function setVpcId(string $VpcId): self
    {
        $this->vpcId = $VpcId;

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
     * @return VPC
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

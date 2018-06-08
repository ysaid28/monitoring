<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Psr\Log\LoggerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 */
class Log  //implements LoggerInterface
{
    use Timestampable;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @var string
     * @ORM\Column(name="subject", type="text", nullable=true)
     */
    protected $subject;

    /**
     * @var int
     *
     * @ORM\Column(name="error_code", type="integer")
     */
    private $errorCode;

    /**
     * @var string
     *
     * @ORM\Column(name="what", type="string", length=512, nullable=true)
     */
    private $what;

    /** @var string
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    protected $message;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @return null| int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param null|string $subject
     * @return Log
     */
    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     * @return Log
     */
    public function setErrorCode(int $errorCode): self
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getWhat(): ?string
    {
        return $this->what;
    }

    /**
     * @param null|string $what
     * @return Log
     */
    public function setWhat(?string $what): self
    {
        $this->what = $what;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     * @return Log
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

}

<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 21/05/2018
 * Time: 18:40
 */

namespace App\Model;

use App\Entity\Instance;
use App\Entity\Project;

interface InstanceInterface extends Sortable, State, Enabled, Timestampable
{

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param null|string $name
     * @return Instance
     */
    public function setName(?string $name): Instance;

    /**
     * @param string $type
     * @return Instance
     */
    public function setType(?string $type): Instance;


    /**
     * @return null|string
     */
    public function getType(): ?string;

    /**
     * @return null|string
     */
    public function getPublicId(): ?string;

    /**
     * @param null|string $publicId
     * @return Instance
     */
    public function setPublicId(?string $publicId): Instance;

    /**
     * @return null|string
     */
    public function getPrivateId(): ?string;

    /**
     * @param null|string $privateId
     * @return Instance
     */
    public function setPrivateId(?string $privateId): Instance;

    /**
     * @return null|string
     */
    public function getHostName(): ?string;

    /**
     * @param null|string $hostName
     * @return Instance
     */
    public function setHostName(?string $hostName): Instance;

    /**
     * @return bool|null
     */
    public function isEnabledSSL(): ?bool;

    /**
     * @param bool|null $enabledSSL
     * @return Instance
     */
    public function setEnabledSSL(?bool $enabledSSL): Instance;

    /**
     * @return bool|null
     */
    public function getEnabledSSL(): ?bool;

    /**
     * @return Project|null
     */
    public function getProject(): ?Project;

    /**
     * @param Project|null $project
     * @return Instance
     */
    public function setProject(?Project $project): Instance;
}
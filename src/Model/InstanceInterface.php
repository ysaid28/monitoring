<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 21/05/2018
 * Time: 18:40
 */

namespace App\Model;

interface InstanceInterface extends Timestampable, Sortable, State
{

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return null|string
     */
    public function getArn(): ?string;

    /**
     * @param null|string $arn
     * @return InstanceInterface
     */
    public function setArn(?string $arn): self;


    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param null|string $name
     * @return InstanceInterface
     */
    public function setName(?string $name): self;


}
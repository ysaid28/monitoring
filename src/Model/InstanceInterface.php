<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 21/05/2018
 * Time: 18:40
 */

namespace App\Model;

use App\Entity\Instance;

interface InstanceInterface extends Timestampable, Sortable, State
{

    /**
     * @return int
     */
    public function getId(): int;
    
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
     * @param string $instanceType
     * @return Instance
     */
    public function setInstanceType(string $instanceType): Instance;


    /**
     * @return string
     */
    public function getInstanceType(): string;
}
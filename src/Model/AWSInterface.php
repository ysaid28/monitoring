<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 26/05/2018
 * Time: 00:18
 */

namespace App\Model;


interface AWSInterface
{
    /**
     * @return string
     */
    public function getInstanceId(): ?string;
    
    /**
     * @param string $instanceId
     */
    public function setInstanceId(?string $instanceId): void;

}
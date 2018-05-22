<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 21/05/2018
 * Time: 18:40
 */

namespace App\Model;


interface InstanceInterface
{

    /**
     * @return int
     */
    public function getId(): int ;
    
    /**
     * @return null|string
     */
    public function getArn(): ?string;

    /**
     * @param null|string $arn
     * @return InstanceInterface
     */
    public function setArn(?string $arn): self;
    


}
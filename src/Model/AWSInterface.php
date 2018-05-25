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
     * @return null|string
     */
    public function getArn(): ?string;

    /**
     * @param null|string $arn
     * @return mixed
     */
    public function setArn(?string $arn);

}
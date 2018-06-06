<?php
/**
 * Created by IntelliJ IDEA.
 * User: UPro
 * Date: 03/06/2018
 * Time: 23:21
 */

namespace App\Service;


use App\Entity\Instance;
use Aws\Sns\SnsClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;


class NotifierService implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    /**
     * @var EntityManagerInterface $em
     *
     */
    protected $em;
    /**
     * @var SnsClient SnsClient
     *
     */
    protected $snsClient;

    /**
     * AwsService constructor.
     * @param EntityManagerInterface $em
     * @param ContainerInterface $container
     * @param SnsClient $snsClient
     */
    public function __construct(EntityManagerInterface $em, ContainerInterface $container, SnsClient $snsClient)
    {
        $this->em = $em;
        $this->container = $container;
        $this->snsClient = $snsClient;
    }

    public function notify(Instance $instance)
    {
        if ($instance->isEnabled()) {

        }

    }


    /**
     * @param $message
     * @param $subject
     * @param bool $prod
     * @internal param $item
     * @internal param $result
     */
    public function sendMessageBySns(string $message, $subject, $prod = false)
    {
        try {
            $dataToPublish = [
                'Message' => $message,
                'Subject' => ($prod === true) ? $subject : '[ DEV ] ' . $subject,
                'TopicArn' => ($prod === true) ? $this->sns['prod'] : $this->sns['dev'],];

            $this->snsClient->publish($dataToPublish);

        } catch (\Exception $e) {
            echo 'Error : ', $e->getMessage(), "\n";
            
        }
    }

}
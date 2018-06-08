<?php
/**
 * Created by IntelliJ IDEA.
 * User: UPro
 * Date: 03/06/2018
 * Time: 23:21
 */

namespace App\Service;


use App\Entity\EC2;
use App\Entity\Instance;
use App\Model\Enum\HttpStatusCode;
use App\Model\Enum\InstanceType;
use Aws\Sns\SnsClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;


class NotifierService implements ContainerAwareInterface
{

    use ContainerAwareTrait;


    /**
     * @var SnsClient SnsClient
     *
     */
    protected $snsClient;


    /**
     * AwsService constructor.
     * @param ContainerInterface $container
     * @param SnsClient $snsClient
     */
    public function __construct(ContainerInterface $container, SnsClient $snsClient)
    {
        $this->container = $container;
        $this->snsClient = $snsClient;
    }
    
    /**
     * @param Instance $instance
     * @param int $code
     * @return array
     */
    public function getMessage(Instance $instance, int $code)
    {
        $message = 'Nom Instance : ' . $instance->getName() . ' \n';;

        if ($instance->getType() == InstanceType::EC2) {
            $message .= 'Instance ID: ' . $instance->getInstanceId() . ' \n';
        }

        if ($instance->getPublicId()) {
            $message .= 'IP Privée: ' . $instance->getPublicId() . ' \n';
        }

        if ($instance->getPrivateId()) {
            $message .= 'IP Publique: ' . $instance->getPrivateId() . ' \n';
        }

        $content = UrlTester::getHTTPResponseCode($code);
        if (isset($content['text'])) {
            $message .= 'Erreur remontée sur : ' . $content['text'] . ' \n';
        }

        if (isset($content['message'])) {
            $message .= 'Explication : ' . $content['message'] . ' \n';
        }

        return [
            'subject' => '[Erreur ' . $code . '] - ' . $instance->getName(), 
            'message' => $message
        ];

    }


    /**
     * @param $message
     * @param $subject
     * @param bool $prod
     * @internal param $item
     * @internal param $result
     */
    public function sendMessageBySns(string $subject, string $message, $prod = false)
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
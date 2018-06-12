<?php
/**
 * Created by PhpStorm.
 * User: yanns
 * Date: 15/05/2018
 * Time: 11:52
 */

namespace App\Service;


use App\Entity\Instance;
use App\Model\Enum\InstanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SSLService
{

    /** @var EntityManqger $em */
    private $em;

    private $minutesToAdd = 10;
    /** @var NotifierService $notif */
    private $notif;

    /**
     * ServiceTester constructor.
     * @param EntityManagerInterface $em
     * @param NotifierService $notif
     */
    public function __construct(EntityManagerInterface $em, NotifierService $notif)
    {
        $this->em = $em;
        $this->notif = $notif;
    }

    public function certificatesChecker(SymfonyStyle $io)
    {
//        $projects = $this->em->getRepository(Instance::class)->getInstanceWithCertificate(true, true, 'ASC',0, null);
        $instances = $this->em->getRepository(Instance::class)->findBy(
            ['enabled' => true,
                'enabledSSL' => true],
            ['certificateEndDate' => 'ASC']
        );
        /** @var Instance $instance */
        foreach ($instances as $instance) {
            $now = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
            $url = 'https://' . $instance->getHostName();
            if ($instance->getHostName() && filter_var($url, FILTER_VALIDATE_URL)) {

                if (empty($instance->getCertificateEndDate())) {
                    $date = self::getCertificateDate($instance->getHostName(), true);
                    $instance->setCertificateStartDate($date['start']);
                    $instance->setCertificateEndDate($date['end']);
                    $this->em->flush($instance);
                }

                if ($instance->isNotified() && $this->sendNotification($instance->getCertificateEndDate(), $now)) {
                    $message = $this->getMessage($instance, $url);
                    if (isset($message['subject']) && isset($message['message'])) {
                        $this->notif->sendMessageBySns($message['subject'], $message['message'], true);
                    }
                    $date = self::getCertificateDate($instance->getHostName(), false);
                    if ($date['end'] > $instance->getCertificateEndDate()) {
                        $instance->setCertificateEndDate($date['end']);
                        $this->em->flush($instance);
                    }
                    $this->write($io, false, $url, $instance->getName());
                } else {
                    $this->write($io, true, $url, $instance->getName());
                }
            }
        }
    }


    /**
     * @param Instance $instance
     * @param string $url
     * @return array
     */
    public function getMessage(Instance $instance, string $url): ?array
    {
        $message = 'Instance : ' . $instance->getName() . " \n";;

        if ($instance->getType() == InstanceType::EC2) {
            $message .= 'Instance ID: ' . $instance->getInstanceId() . " \n";
        }

        if ($instance->getHostName()) {
            $message .= 'URL: ' . $instance->getName() ." \n";
        }
        
        if ($url) {
            $message .= 'URL: ' . $url ." \n";
        }

        $message .= "Expiration date : " . $instance->getCertificateEndDate()->format('d F Y h:i:s');
        $message .= " \n\nAWS Management";

        return [
            'subject' => '[SSL Certificate] - ' . $instance->getName(),
            'message' => $message
        ];
    }


    /**
     * @param string $hostName
     * @param bool|null $start
     * @return array
     */
    public static function getCertificateDate(string $hostName, ?bool $start = false): array
    {
        $result = ["start" => null, "end" => null];
        $get = stream_context_create(["ssl" => ["capture_peer_cert" => TRUE]]);
        $read = stream_socket_client("ssl://" . $hostName . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certInfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        if ($start === true && isset($certInfo['validFrom_time_t']) && !empty($certInfo['validFrom_time_t'])) {
            $result['start'] = (new \DateTime())->setTimestamp($certInfo['validFrom_time_t']);
        }
        if (isset($certInfo['validTo_time_t']) && !empty($certInfo['validTo_time_t'])) {
            $result['end'] = (new \DateTime())->setTimestamp($certInfo['validTo_time_t']);
        }
        return $result;
    }


    /**
     * @param \DateTime|null $date
     * @param \DateTime $now
     * @return bool
     * @throws \Exception
     */
    public function sendNotification(?\DateTime $date, \DateTime $now): bool
    {

        if ($date instanceof \DateTime && $date !== null) {
            $diff = $date->diff($now);
            // S-1 Semaine avant J-3 Jours avant, J-1 and J 
            return ($diff->m == 0 && (in_array($diff->d, [7, 3]) || $diff <= 1));
        }
        return true;
    }

    /**
     * @param SymfonyStyle $io
     * @param null|string $url
     * @param null|string $name
     */
    private function write(SymfonyStyle $io, bool $success, ?string $url, ? string $name): void
    {
        $date = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
        $message = '[' . $date->format('d/m/Y H:i:s') . ']';

        $message .= ' [' . ($success ? 'OK' : 'FAILED') . ']';

        if ($name) {
            $message .= ' - Name: ' . $name;
        }
        if ($url) {
            $message .= ' - URL: ' . $url;
        }


        $io->writeln($message);
    }


}

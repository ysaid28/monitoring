<?php
/**
 * Created by PhpStorm.
 * User: yanns
 * Date: 15/05/2018
 * Time: 11:52
 */

namespace App\Service;


use App\Entity\Instance;
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
            ['enabled' => true, 'enabledSSL' => true],
            ['certificateEndDate' => 'ASC']
        );
        /** @var Instance $instance */
        foreach ($instances as $instance) {
            $url = 'https://' . $instance->getHostName();
            if ($instance->getHostName() && filter_var($url, FILTER_VALIDATE_URL)) {
                $date = self::getCertificateDate($instance->getHostName());
                dump($date);

            }
//            dump($instance);
            die;
        }
        die;

        die('Test');
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
            $temp = new \DateTime($date->format('Y-m-d H:i'), new \DateTimeZone("Europe/Paris"));
            $temp->add(new \DateInterval('PT' . $this->minutesToAdd . 'M'));
            return ($temp <= $now);
        }
        return true;
    }


}

<?php
/**
 * Created by PhpStorm.
 * User: yanns
 * Date: 15/05/2018
 * Time: 11:52
 */

namespace App\Service;

use App\Entity\Instance;
use App\Entity\Project;
use App\Model\Enum\HttpStatusCode;
use App\Model\Enum\InstanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceTester implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var EntityManqger $em */
    private $em;
    /** @var UrlTester $urlTester */
    private $urlTester;

    private $minutesToAdd = 10;
    /** @var NotifierService $notif */
    private $notif;

    /**
     * ServiceTester constructor.
     * @param EntityManagerInterface $em
     * @param ContainerInterface $container
     * @param UrlTester $urlTester
     * @param NotifierService $notif
     */
    public function __construct(EntityManagerInterface $em, ContainerInterface $container, UrlTester $urlTester, NotifierService $notif)
    {
        $this->em = $em;
        $this->container = $container;
        $this->urlTester = $urlTester;
        $this->notif = $notif;
    }

    /**
     * @param SymfonyStyle $io
     * @return bool
     */
    public function test(SymfonyStyle $io): bool
    {
        $projects = $this->em->getRepository(Project::class)->getProjects();
        if (empty($projects)) {
            $io->warning("No Project enabled");
            return false;
        } else {
            $io->title('Services test');
            /** @var Project $project */
            foreach ($projects as $project) {
                $io->section(sprintf('Check %s services', $project->getName()));
                foreach ($project->getInstances() as $instance) {
                    $url = $this->getUrl($instance);
                    if ($url && filter_var($url, FILTER_VALIDATE_URL) && $instance->isEnabled()) {
//                        $httpCode = $this->urlTester->httpStatusCode($url, null);
                        $httpCode = 300;
                        if (HttpStatusCode::isValid($httpCode)) {
                            $this->write($io, strval($httpCode), $url, $instance->getName(), null);
                            if (HttpStatusCode::OK !== $httpCode) {
                                // Send Notification
                                $now = (new \DateTime("now"))->setTimezone(new \DateTimeZone("Europe/Paris"));
                                if ($instance->isNotified() && $this->checkLastNotification($instance->getDateNotification(), $now)) {
                                    dump('notifier');
                                    $instance->setDateNotification($now);
                                    $message = $this->notif->getMessage($instance, $httpCode);
                                    if (isset($message['subject']) && isset($message['message'])) {
                                        $this->notif->sendMessageBySns($message['subject'], $message['message'], false);
                                    }
                                    // Add Log

                                }

                            } else {
                                dump($httpCode);
                                die;
                            }
                        } else {
                            $io->error(sprintf('Http Code %s not valid', $url) . ' ');
                        }
                        //Lance le fixture 
                        // Update Services
                        // Log 

                    }

                }

                $io->success(sprintf('Finished  %s Services Tester', $project->getName()));

            }
            $io->success('END SERVICES TESTER');
            return true;
        }
    }

    public function addLog()
    {
        
    }

    /**
     * @param Instance $instance
     * @return null|string
     */
    private function getUrl(Instance $instance): ? string
    {
        $url = "";
        if ($instance->isEnabledSSL() && $instance->getHostName()) {
            $url .= "https://" . $instance->getHostName();
        } else {
            $url .= "http://" . ($instance->getHostName() ? $instance->getHostName() :
                    ($instance->getPublicId() ? $instance->getPublicId() : $instance->getPrivateId()));
        }
        $url .= '/login';
        // Il faudra une u
        return $url;
    }

    /**
     * @param SymfonyStyle $io
     * @param null|string $codeCurl
     * @param null|string $url
     * @param null|string $name
     * @param null|string $ip
     */
    private function write(SymfonyStyle $io, ?string $codeCurl, ?string $url, ? string $name, ?string $ip): void
    {
        $date = (new \DateTime())->setTimezone(new \DateTimeZone("Europe/Paris"));
        $message = '[' . $date->format('d/m/Y H:i:s') . ']';

        if ($codeCurl) {
            $message .= '[Code:' . $codeCurl . ']';
        }

        if ($name) {
            $message .= ' - Name: ' . $name;
        }
        if ($url) {
            $message .= ' - URL: ' . $url;
        }

        if ($ip) {
            $message .= ' - IP: ' . $ip;
        }
        $io->writeln($message);
    }


    /**
     * @param \DateTime|null $date
     * @param \DateTime $now
     * @return bool
     * @throws \Exception
     */
    public function checkLastNotification(?\DateTime $date, \DateTime $now): bool
    {
        if ($date instanceof \DateTime && $date !== null) {
            $temp = new \DateTime($date->format('Y-m-d H:i'));
            $temp->add(new \DateInterval('PT' . $this->minutesToAdd . 'M'));

            return ($temp <= $now) ?? false;
        }
        return true;
    }

}

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

    /**
     * ServiceTester constructor.
     * @param EntityManagerInterface $em
     * @param ContainerInterface $container
     */
    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
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
                    if ($project->getType() == InstanceType::EC2) {
                        $url = $this->getUrl($instance);
                    } elseif ($project->getType() == InstanceType::OTHER) {
                        $url = $this->getUrl($instance);
                    } else {
                        $url = null;
                    }
                    $this->write($io, "200", $url, $instance->getName(), null);
                }
                $io->success(sprintf('Finished  %s Services Tester', $project->getName()));

            }
            $io->success('END SERVICES TESTER');
            return true;
        }
    }

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


}

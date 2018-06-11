<?php
/**
 * Created by IntelliJ IDEA.
 * User: yanns
 * Date: 23/05/2018
 * Time: 19:13
 */

namespace App\Service;


use App\Entity\EC2;
use App\Entity\OtherInstance;
use App\Entity\Project;
use App\Entity\Subnet;
use App\Entity\VPC;
use App\Model\Enum\InstanceState;
use App\Model\State;
use Aws\Api\DateTimeResult;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

//use Doctrine\ORM\EntityManagerInterface;

/**
 * @property EntityManager em
 */
class InitService implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var EntityManager $em */
    private $em;

    /**
     * InitService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }

    /**
     * @param array $data
     * @param string $key
     * @return any|null
     */
    public function getData(array $data, string $key)
    {
        return isset($data[$key]) ? $data[$key] : null;
    }

    /**
     * @param array $data
     * @return EC2
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function instanceEC2(array $data): ?EC2
    {
        $instanceId = $this->getData($data, 'InstanceId');
        if (empty($instanceId))
            return null;

        $ec2 = $this->em->getRepository(EC2::class)->findOneByInstanceId($instanceId);
        if (null === $ec2 || !($ec2 instanceof EC2)) {
            $ec2 = new EC2();
            $ec2->setInstanceId($instanceId);
        }
        $methods = [
            'ImageId', 'KeyName', 'PublicIpAddress', 'PrivateIpAddress', 'PublicDnsName', 'PrivateDnsName',
            'StateTransitionReason', 'ClientToken', 'EbsOptimized', 'InstanceType',
            'EnaSupport', 'Hypervisor', 'SourceDestCheck', 'VirtualizationType', 'CpuOptions', 'Architecture'
        ];

        $launchTime = $this->getData($data, 'LaunchTime');
        if ($launchTime instanceof DateTimeResult) {
            $ec2->setLaunchTime(new \DateTime($launchTime->format('Y-m-d H:i:s')));
        }

        foreach ($methods as $item) {
            $method = 'set' . $item;
            if (method_exists($ec2, $method)) {
                $ec2->$method($this->getData($data, $item));
            }
        }
        if (isset($data['Tags']) && is_array($data['Tags'])) {
            foreach ($data['Tags'] as $tag) {
                if (is_array($tag) && in_array('Name', $tag)) {
                    $ec2->setName(isset($tag['Value']) ? $tag['Value'] : null);
                    break;
                }
            }
        }

        $ec2->setState(isset($data["State"]["Name"]) ? strtolower($data["State"]["Name"]) : InstanceState::UNKNOWN);
        $ec2->setEnabled(true);
        $ec2->setEnabledNotification(true);
        // A MODIFIER
        $url = 'https://' . $ec2->getName();
        if ($ec2->getName() && filter_var($url, FILTER_VALIDATE_URL)) {
//            ["scheme" => $scheme, "host" => $host] = parse_url($url);
            $host = parse_url($url, PHP_URL_HOST);
            $ip = gethostbyname($host);
            if ($ip == $ec2->getPublicIpAddress()
                && filter_var($ec2->getPublicIpAddress(), FILTER_VALIDATE_IP)) {
                $ec2->setEnabledSSL(parse_url($url, PHP_URL_SCHEME) == 'https' ?? false);
                $ec2->setPublicId($ip ? $ip : null);

                if (!empty($host)) {
                    $ec2->setHostName($host);
                    $date = SSLService::getCertificateDate($host, true);
                    $ec2->setCertificateStartDate($date['start']);
                    $ec2->setCertificateEndDate($date['end']);
                }
            }

        }

        $vpcId = $this->getData($data, 'VpcId');
        if ($vpcId) {
            $vpc = $this->em->getRepository(VPC::class)->findOneByVpcId($vpcId);
            if (null === $vpc) {
                $vpc = (new VPC())->setVpcId($vpcId)->addEc2($ec2);
                $this->em->persist($vpc);
            }
            $ec2->setVpc($vpc);
        }
        $subnetId = $this->getData($data, 'SubnetId');
        if ($subnetId) {
            $subnet = $this->em->getRepository(Subnet::class)->findOneBySubnetId($subnetId);
            if (null === $subnet) {
                $subnet = (new Subnet())->setSubnetId($subnetId)->addEc2($ec2);
                $this->em->persist($subnet);
            }
            $ec2->setSubnet($subnet);
        }
        if ($ec2->getId() === null) {
            $this->em->persist($ec2);
            $this->em->flush($ec2);
            $ec2 = $this->em->getRepository(EC2::class)->findOneByInstanceId($instanceId);
        } else
            $this->em->flush($ec2);
        return $ec2;
    }


    public function otherInstance(Project $project, string $nameFile): void
    {
        $filepath = $this->container->getParameter('kernel.root_dir') . '/../var/data/' . $nameFile;
        if (!file_exists($filepath)) {
            throw new \UnexpectedValueException(" The file \"'$nameFile'\" doesn't exist");
        } else if (empty($project) || !($project instanceof Project)) {
            throw new \UnexpectedValueException(" Project not found");
        }

        if (($handle = fopen($filepath, 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                if ($i > 0 && is_array($data)) {
                    $name = current($data);
                    $instance = $this->em->getRepository(OtherInstance::class)->findOneByCustomer($name);
                    if (null == $instance) {
                        [$customer, $serverName, $url, $licence, $sso, $webservice, $provision, $customed, $versionProd, $versionStaging] = $data;
                        $instance = new OtherInstance();
                        $instance->setCustomer($customer)
                            ->setName($serverName)
                            ->setLicence($licence)
                            ->setSso($sso == '-' || empty($sso) ? null : $sso)
                            ->setEnabledWebservice($webservice == 'oui' ? true : false)
                            ->setEnabledProvision($provision == 'oui' ? true : false)
                            ->setCustom($customed == 'oui' ? true : false)
                            ->setMajorProductionVersion(strtoupper($versionProd))
                            ->setMajorStagingVersion(strtoupper($versionStaging))
                            ->setPosition(0);
                        $instance->setState(InstanceState::RUNNING);
                        $instance->setEnabled(true);
                        $instance->setEnabledNotification(true);
                        $instance->setProject($project);

                        if (filter_var($url, FILTER_VALIDATE_URL)) {
                            $host = parse_url($url, PHP_URL_HOST);
                            $instance->setHostName($host);
                            if (!empty($host)) {
                                $instance->setHostName($host);
                                $date = SSLService::getCertificateDate($host, true);
                                $instance->setCertificateStartDate($date['start']);
                                $instance->setCertificateEndDate($date['end']);
                            }

                            $instance->setEnabledSSL(parse_url($url, PHP_URL_SCHEME) == 'https' ?? false);
                            $ip = gethostbyname($host);
                            $instance->setPublicId($ip ? $ip : null);
                        }
                        $this->em->persist($instance);
                        $project->addInstance($instance);
                        if ($i % 10 == 0) {
                            $this->em->flush();
                        }
                    }
                }
                $i++;
            }
            $this->em->flush();
            fclose($handle);
        }
    }
}

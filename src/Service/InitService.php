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
use App\Entity\Subnet;
use App\Entity\VPC;
use App\Model\Enum\InstanceState;
use App\Model\State;
use Doctrine\ORM\EntityManager;
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
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, ContainerInterface $container)
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
            'ImageId', 'KeyName', 'LaunchTime', 'PublicIpAddress', 'PrivateIpAddress', 'PublicDnsName', 'PrivateDnsName',
            'StateTransitionReason', 'ClientToken', 'EbsOptimized', 'InstanceType',
            'EnaSupport', 'Hypervisor', 'SourceDestCheck', 'VirtualizationType', 'CpuOptions', 'Architecture'
        ];
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
        $vpcId = $this->getData($data, 'VpcId');
        if ($vpcId) {
            $vpc = $this->em->getRepository(VPC::class)->findOneByVpcId($vpcId);
            if (null === $vpc) {
                $vpc = (new VPC())
                    ->setVpcId($vpcId)
                    ->addEc2s($ec2);
                $this->em->persist($vpc);
            }
            $ec2->setVpc($vpc);
        }
        $subnetId = $this->getData($data, 'SubnetId');
        if ($subnetId) {
            $subnet = $this->em->getRepository(Subnet::class)->findOneBySubnetId($subnetId);
            if (null === $subnet) {
                $subnet = (new Subnet())
                    ->setSubnetId($subnetId)
                    ->addEc2s($ec2);
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


    public function otherInstance(string $nameFile): void
    {
        $filepath = $this->container->getParameter('kernel.root_dir') . '/../var/data/' . $nameFile;
        if (!file_exists($filepath)) {
            throw new \UnexpectedValueException(" The file \"'$nameFile'\" doesn't exist");
        }
        if (($handle = fopen($filepath, 'r')) !== false) {
            $i = 0;
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                if ($i > 0 && is_array($data)) {
                    $name = current($data);
                    $instance = $this->em->getRepository(OtherInstance::class)->findOneByName($name);
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
                        $instance->setState(InstanceState::ENABLE);


                        if (filter_var($url, FILTER_VALIDATE_URL)) {
                            ["scheme" => $scheme, "host" => $host] = parse_url($url);
                            $instance->setEnabledSSL($scheme == 'https' ?? false);
                            $instance->setHostName($host);
                            $ip = gethostbyname($host);
                            $instance->setPublicId($ip ? $ip : null);
                        }
                        $this->em->persist($instance);
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



/*
 *   [ 
  0 =>   [ 
    "AmiLaunchIndex" => 0
    "ImageId" => "ami-8ee056f3"
    "InstanceId" => "i-02fd0dbb76cb58a57"
    "InstanceType" => "t2.micro"
    "KeyName" => "ys-dev"
    "LaunchTime" => DateTimeResult @1524148776 {#295  
      date: 2018-04-19 14:39:36.0 +00:00
    }
    "Monitoring" =>   [ 
      "State" => "disabled"
    ]
    "Placement" =>    [ 
      "AvailabilityZone" => "eu-west-3c"
      "GroupName" => ""
      "Tenancy" => "default"
    ]
    "PrivateDnsName" => "ip-172-31-42-155.eu-west-3.compute.internal"
    "PrivateIpAddress" => "172.31.42.155"
    "ProductCodes" => []
    "PublicDnsName" => ""
    "State" =>    [ 
      "Code" => 80
      "Name" => "stopped"
    ]
    "StateTransitionReason" => "User initiated (2018-04-19 14:40:50 GMT)"
    "SubnetId" => "subnet-38938f72"
    "VpcId" => "vpc-c73e98ae"
    "Architecture" => "x86_64"
    "BlockDeviceMappings" =>   [ 
      0 =>    [ 
        "DeviceName" => "/dev/xvda"
        "Ebs" => array:4 [ 
          "AttachTime" => DateTimeResult @1518775278 {#357 ▶}
          "DeleteOnTermination" => true
          "Status" => "attached"
          "VolumeId" => "vol-05a5052127c9c468c"
        ]
      ]
    ]
    "ClientToken" => ""
    "EbsOptimized" => false
    "EnaSupport" => true
    "Hypervisor" => "xen"
    "NetworkInterfaces" =>   [▶]
    "RootDeviceName" => "/dev/xvda"
    "RootDeviceType" => "ebs"
    "SecurityGroups" =>   [▶]
    "SourceDestCheck" => true
    "StateReason" =>    [▶]
    "Tags" =>    [▶]
    "VirtualizationType" => "hvm"
    "CpuOptions" =>    [ 
      "CoreCount" => 1
      "ThreadsPerCore" => 1
    ]
  ]
]*/

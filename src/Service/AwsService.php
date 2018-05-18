<?php
/**
 * Created by PhpStorm.
 * User: yanns
 * Date: 15/05/2018
 * Time: 11:52
 */

namespace App\Service;


use Aws\Credentials\Credentials;
use Aws\Ec2\Ec2Client;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AwsService implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    /**
     * @var
     * array
     * */
    private $env = ['prod', 'staging'];

    /**
     * AwsService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }

    /**
     * @param string $key
     * @param string $secret
     * @param null $token
     * @param null $expires
     * @return Credentials
     */
    public function getNewCredentials(string $key, string $secret, $token = null, $expires = null): Credentials
    {
        return new Credentials($key, $secret, $token, $expires);
    }


    /**
     * @param iterable $filters
     * @return array
     */
    public function addFilters(iterable $filters = []): array
    {
        $data = [];
        foreach ($filters as $key => $val) {
            $data[] = ['Name' => 'tag-key', 'Values' => [$key]];
            $data[] = ['Name' => 'tag-value', 'Values' => [$val]];
        }
        return $data;
    }

    public function getResults(array $data): array
    {
        $instances = [];
        list('Reservations' => $reservations) = $data;
        foreach ($reservations as $reservation) {
            if (isset($reservation['Instances']))
                $instances = $instances['Instances'];
        }
        return $instances;
    }


    /**
     * @param array $filters
     * @return array
     */
    public function getInstances(array $filters = []): ?array
    {
        $credentials = $this->container->get('aws_credentials_service');
        $ec2 = new Ec2Client(['version' => 'latest', 'region' => 'eu-west-3', 'credentials' => $credentials]);

        $data = $ec2->describeInstances([
            'DryRun' => false,
            'Filters' => !empty($filters) ? $this->addFilters($filters) : []
        ])->toArray();
        
        return $this->getResults($data);
    }


}


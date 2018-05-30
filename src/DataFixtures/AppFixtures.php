<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    private $container;


    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ContainerInterface $container
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ContainerInterface $container)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
        $this->loadInstances($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    private function getUserData(): array
    {
        /*
         * [$fullName, $username, $password, $email, $roles]
         */
        return [
            ['Yannick SAID', 'ysaid', 'yann', 'ysaid@u-pro.fr', ['ROLE_ADMIN']],
            ['Florian LEPOT', 'flepot', 'flopass', 'flepot@u-pro.fr', ['ROLE_ADMIN']],
        ];
    }

    private function loadInstances(ObjectManager $manager): void
    {
        $name = 'AWS';
        $tags = ["Env" => "staging"];
        $project = $manager->getRepository(Project::class)->findOneByName($name);
        if (empty($project) || !($project instanceof Project)) {
            $project = new Project();
            $project->setName($name)->getTags($tags);
            $manager->persist($project);
        }
        $instances = $this->container->get('app.aws')->getInstanceEc2($tags);
        foreach ($instances as $key => $i) {
            $project->addInstance($i);
            if ($key % 10 == 0) $manager->flush();
        }
        $manager->flush();

        $file = 'netexplo.csv';
        $name = 'Netexplo';
        $tags = ['netexplo'];
        
        $project = $manager->getRepository(Project::class)->findOneByName($name);
        if (empty($project) || !($project instanceof Project)) {
            $project = new Project();
            $project->setName($name)->getTags($tags);
            $manager->persist($project);
            $manager->flush($project);
        }

        $this->container->get('app.init')->otherInstance($project, $file);
        unset($project);

    }


}

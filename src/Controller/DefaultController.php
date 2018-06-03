<?php

namespace App\Controller;

use App\Entity\EC2;
use App\Entity\Instance;
use App\Entity\Project;
use App\Service\AwsService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {

//        $instances = $this->get('app.aws')->getInstanceEc2(["Env" => "staging"]);
//        dump($instances) or die;
        
        //A changer
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        return $this->render('default/index.html.twig', [
            'projects' => $projects
        ]);
    }


}

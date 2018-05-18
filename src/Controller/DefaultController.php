<?php

namespace App\Controller;

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
        /** @var AwsService $aws */
        $aws = $this->get('app.aws.service');
        $aws->addFilters(['Name' => 'develop', 'Env' => "teset"]);
        $instance= $aws->getInstances(["Name" => "develop", "Env"=> "staeging"]);
        
        die('Home Page');
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}

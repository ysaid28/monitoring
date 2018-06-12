<?php

namespace App\Controller;

use App\Entity\EC2;
use App\Entity\Instance;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Service\AwsService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ProjectRepository $projectRepository)
    {
        $projects = $projectRepository->getProjects();
        return $this->render('default/index.html.twig', [
            'projects' => $projects
        ]);
    }
    
}

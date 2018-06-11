<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/projects")
 */
class ProjectController extends Controller
{
    /**
     * @Route("/", name="project_index")
     */
    public function index()
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    /**
     * @Route("/notify", name="project_notification",  options = {"expose"=true})
     * @param Request $request
     * @return JsonResponse
     */
    function projectNotifyAction(Request $request)
    {
        $success = false;
        
        if ($request->isXmlHttpRequest()) {
            $projectId = intval($request->get('id'));
            $em = $this->getDoctrine()->getManager();
            /** @var Project $project */
            $project = $em->getRepository(Project::class)->find($projectId);
            if (null !== $project) {
                $state = $request->get('state') == 'true' ?? false;
                $project->setEnabledNotification($state);
                $em->flush($project);
                if ($project->isNotified()) {
                    $message = $project->getName() . ' notificaiton reactived';
                } else {
                    $message = $project->getName() . ' notificaiton disabled';
                }
            } else {
                $message = 'No project found';
            }
        } else {
            $message = 'The request is not an XMLHttpRequest ';
        }
        return new JsonResponse(['success' => $success, 'message' => $message]);
    }

}

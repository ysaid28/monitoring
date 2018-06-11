<?php

namespace App\Controller;

use App\Entity\Instance;
use App\Repository\InstanceRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/instances")
 */
class InstanceController extends Controller
{
    /**
     * @Route("/", name="instance_index")
     */
    public function index()
    {
        return $this->render('instance/index.html.twig', [
            'controller_name' => 'InstanceController',
        ]);
    }

    /**
     * @Route("/notified", name="instance_notification",  options = {"expose"=true})
     * @param Request $request
     * @return JsonResponse
     */
    function notifAction(Request $request)
    {
        
        $success = false;
        if ($request->isXmlHttpRequest()) {
            $instanceId = intval($request->get('id'));
            $em = $this->getDoctrine()->getManager();
            /** @var Instance $instance */
            $instance = $em->getRepository(Instance::class)->find($instanceId);
            if (null !== $instance) {
                $state = $request->get('state') == 'true' ?? false;
                $instance->setEnabled($state);
                $em->flush($instance);
                if($instance->isEnabled()){
                    $message='the instance '.$instance->getName(). ' has been reactived';
                }else{
                    $message='the instance '.$instance->getName(). ' has been disabled';
                }
            } else {
                $message = 'No instance found';
            }
        } else {
            $message = 'The request is not an XMLHttpRequest ';
        }
        return new JsonResponse(['success' => $success, 'message' => $message]);
    }

}

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
     * @Route("/cron", name="instance_cron")
     */
    public function outputAction()
    {
        $filePath = $this->container->getParameter('kernel.root_dir') . '/../var/data/notifier.log';

        if (!file_exists($filePath)) {
            $this->setFlash("danger", '<i class="fa fa-warning"></i>  No log file found.');
            return $this->redirectToRoute('home_page');
        }

        $logs = array();
        if (($handle = fopen($filePath, 'r')) !== false) {
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    //$logs = explode("\r", $line);
                    $logs[] = $line;
                }
                if (!feof($handle)) {
                    $this->setFlash("danger", '<i class="fa fa-warning"></i> <strong>Erreur:</strong> fgets() a échoué\n.');
                    return $this->redirectToRoute('homepage');
                }

            } else {
                $this->setFlash("danger", '<i class="fa fa-warning"></i> <strong>Error:</strong> opening the file.');
                return $this->redirectToRoute('homepage');
            }

        } else {
            $this->setFlash("danger", '<i class="fa fa-warning"></i> <strong>Error:</strong> opening the file.');
            return $this->redirectToRoute('homepage');
        }
        fclose($handle);
        unset($handle, $filePath);
      
        return $this->render('instance/log_output.html.twig', [
            "logs" => $logs
        ]);

    }

    private function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
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
                if ($instance->isEnabled()) {
                    $message = 'the instance ' . $instance->getName() . ' has been reactived';
                } else {
                    $message = 'the instance ' . $instance->getName() . ' has been disabled';
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

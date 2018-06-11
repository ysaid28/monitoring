<?php

namespace App\Controller;

use App\Repository\InstanceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/certificates")
 */
class CertificateController extends Controller
{
    /**
     * @Route("/", name="certificate_index")
     * @param InstanceRepository $iRepo
     * @return Response
     */
    public function index(InstanceRepository $iRepo)
    {
        $instances = $iRepo->getInstanceWithCertificate();
        return $this->render('certificate/index.html.twig', [
            'instances' => $instances,
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
*/
class LaboratoryController extends AbstractController
{
    /**
     * @Route("/laboratory", name="laboratory")
     */
    public function index(): Response
    {
        return $this->render('laboratory/index.html.twig', [
            'controller_name' => 'LaboratoryController',
        ]);
    }
}

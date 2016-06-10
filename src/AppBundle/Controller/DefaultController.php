<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        /*return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
        //return $this->render('testo/home-not-logged.html.twig', [
        $oUser = new User();
        $oUser->setNEquips(22);
        $oUser->setNCertificats(13);
        //$oUser->setSTipusClient('sap');

        $em = $this->getDoctrine()->getManager();
        $em->persist($oUser);
        $em->flush();

        return $this->render('testo/resumen.html.twig', [
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
          'user' => "carles",
        ]);

    }
}

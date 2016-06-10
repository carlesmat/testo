<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UsersController extends Controller
{
  public function getUsersAction($username){
    $oUsersRepository = $this->getDoctrine()->getRepository('AppBundle:User');
    $aUsers = $oUsersRepository->findAll();
    //$oUsers = new ArrayCollection($aUsers);

    $encoders = array(new XmlEncoder(), new JsonEncoder());
    $normalizers = array(new ObjectNormalizer());

    $serializer = new Serializer($normalizers, $encoders);

    $jsonContent = $serializer->serialize($aUsers, 'json');

    $response = new Response($jsonContent);
    $response->headers->set('Access-Control-Allow-Credentials: true');
    $response->headers->set('Access-Control-Allow-Origin: http://192.168.1.196:8100');

    return $response;
  }
}

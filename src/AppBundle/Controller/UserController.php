<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserController extends Controller
{
    /**
     * Dashboard d'usuari
     */
    public function resumenAction(Request $request)
    {
        // Recuperem l'usuari (ja ho farem posteriorment a partir de l'id d'usuari real)
        $userId = 1;
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
          ->getRepository('AppBundle:User')
          ->find($userId);

        // replace this example code with whatever you need
        return $this->render('user/resumen.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'user' => $user,
          ]);
    }

    /**
     * Equipos asociados a un usuario
     */
    public function equiposAction(Request $request)
    {
        // Recuperem l'usuari (ja ho farem posteriorment a partir de l'id d'usuari real)
        $userId = 1;
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
          ->getRepository('AppBundle:User')
          ->find($userId);

        $equipos = $em->getRepository('AppBundle:User')->getEquipos($user);

        // replace this example code with whatever you need
        return $this->render('user/equipos.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'user' => $user,
            'equipos' => $equipos
          ]);
    }

    /**
     * Detalle de un equipo
     */
    public function equipoAction($nserie)
    {
        // El número de serie ve amb url_encode
        $nserie = urldecode($nserie);
        // Recuperem l'usuari (ja ho farem posteriorment a partir de l'id d'usuari real)
        $userId = 1;
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
          ->getRepository('AppBundle:User')
          ->find($userId);

        // Recuperem el número de sèrie de l'equip i comprobem que l'equip existeix
        $equipo = $em->getRepository('AppBundle:Equipo')->findOneByNSerie($nserie);

        // TODO: controlar si l'equip no existeix o l'usuari n oté permisos per veure l'equip

        // replace this example code with whatever you need
        return $this->render('user/equipo.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'user' => $user,
            'equipo' => $equipo
          ]);
    }

    /**
     * Certificados de un usuario
     */
    public function certificadosAction(Request $request)
    {
        // Recuperem l'usuari (ja ho farem posteriorment a partir de l'id d'usuari real)
        $userId = 1;
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
          ->getRepository('AppBundle:User')
          ->find($userId);

        $certis = $em->getRepository('AppBundle:User')->getCertificados($user);

        // replace this example code with whatever you need
        return $this->render('user/certificados.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'user' => $user,
            'certis' => $certis
          ]);
    }

    /**
     * Devuelve un patrón en formato pdf
     */
    public function patronAction($nombre)
    {
        // Primer comprovem si existeix el fitxer del patró
        // El nom ens arriba urlencoded
        $nombre = urldecode($nombre);
        //En comptes de / tenim -
        $nombre = str_replace('/','-',$nombre);
        // Comprovem tant .df com .PDF
        $file = realpath($this->get('kernel')->getRootDir().'/../var/data/patrones/'.$nombre.'.pdf');
        if (file_exists($file)) {
            return new BinaryFileResponse($file);
        }
        $file = realpath($this->get('kernel')->getRootDir().'/../var/data/patrones/'.$nombre.'.PDF');
        if (file_exists($file)) {
            return new BinaryFileResponse($file);
        }

        return new Response(
          '<html><body>Patrón: '.$nombre.' no encontrado!!</body></html>');
    }

    /**
     * Devuelve un certificado en formato pdf
     */
    public function certificadoAction($nombre)
    {
        // Primer comprovem si existeix el fitxer del patró
        return new Response(
          '<html><body>¡¡Certificado: '.$nombre.' no encontrado!!</body></html>');
        return new BinaryFileResponse(realpath($this->get('kernel')->getRootDir().'/../app/Resources/data/certi.pdf'));
    }

    public function usuarisAction(Request $request)
    {
      $oUsersRepository = $this->getDoctrine()->getRepository('AppBundle:User');
      $aUsers = $oUsersRepository->findAll();
      //echo "<pre>";print_r($aUsers);echo "</pre>";


      $encoders = array(new XmlEncoder(), new JsonEncoder());
      $normalizers = array(new ObjectNormalizer());

      $serializer = new Serializer($normalizers, $encoders);

      $jsonContent = $serializer->serialize($aUsers, 'json');
      //echo $jsonContent; // or return it in a Response

      //echo "<br>";

      $XMLContent = $serializer->serialize($aUsers, 'xml');
      //echo "<pre>";echo(htmlentities($XMLContent));echo "</pre>"; exit();// or return it in a Response

        // replace this example code with whatever you need
        /*return $this->render('user/resumen.html.twig', [
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'user' => $user,
          ]);*/
        //return new Response($jsonContent);
        //return new Response($XMLContent);

        $response = new Response($jsonContent);
        //$response->headers->set('Access-Control-Allow-Credentials: true');
        //$response->headers->set('Access-Control-Allow-Origin:', '*');
        //$response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
//$response->setPublic();
        //$response->headers->set('Access-Control-Allow-Origin', '*');
        //$response->headers->set('Access-Control-Allow-Methods', 'GET,POST,OPTIONS');

        return $response;
    }
}

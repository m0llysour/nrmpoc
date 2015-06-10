<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    /**
     * @Rest\View
     */
    public function allAction()
    {
        $res = $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->createQueryBuilder('e')
            ->select('e')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return new Response(json_encode($res));
    }

    /**
     * @Rest\View
     */
    public function getAction($id)
    {
        $res = $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->createQueryBuilder('e')
            ->select('e')
            ->where('e =:getId')->setParameter('getId', $id)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return new Response(json_encode($res && is_array($res) && count($res) == 1? $res[0] : null));
    }

    /**
     * @Rest\View
     */
    public function createAction(Request $request)
    {
        $res = json_decode($request->getContent())->name;

        $client = new Client();
        $client->setName($res);
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();

        return new Response();
    }

    /**
     * @Rest\View
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($id);
        $em->remove($client);
        $em->flush();

        return new Response();
    }

    /**
     * @Rest\View
     */
    public function updateAction($id, Request $request)
    {
        $res = json_decode($request->getContent())->name;

        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->find($id);
        $client->setName($res);
        $em->flush();

        return new Response();
    }
}
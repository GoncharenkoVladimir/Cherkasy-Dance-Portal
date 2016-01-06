<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     * @return Post
     */
    public function mainAction(Request $request)
    {
        $repository = $this->getDoctrine();
        $query = $repository->getRepository('AppBundle:Post')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return ['posts' => $pagination];
    }

    /**
     * @Route("/infinity-scroll", name="infinity-scroll")
     */
    public function fffAction(Request $request)
    {
        $repository = $this->getDoctrine();
        $query = $repository->getRepository('AppBundle:Post')->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return new JsonResponse(['posts' => $pagination->getItems()]);
    }
}

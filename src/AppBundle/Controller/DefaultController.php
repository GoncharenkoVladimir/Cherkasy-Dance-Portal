<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/{tag}", name="homepage", defaults={"tag" = 0})
     * @Template()
     * @param string $tag
     * @return Post
     */
    public function mainAction($tag, Request $request)
    {
        $repository = $this->getDoctrine();
        $tags = $repository->getRepository('AppBundle:Tag')->findAll();
        if($tag == '0'){
            $query = $repository->getRepository('AppBundle:Post')->findAll();
        }else{

            /**
             * @var \AppBundle\Entity\Tag $tagView
             */
            $tagView = $repository->getRepository('AppBundle:Tag')->findOneByName($tag);
            $query = $tagView->getPosts();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return ['posts' => $pagination, 'tags' => $tags, 'tag'=> $tag];
    }

    /**
     * @Route("/infinity-scroll/scroll/{tag}", name="infinity-scroll", defaults={"tag" = 0})
     * @param Tag $tag
     * @return array
     */
    public function fffAction($tag, Request $request)
    {
        $repository = $this->getDoctrine();
        $tags = $repository->getRepository('AppBundle:Tag')->findAll();
        if($tag == '0'){
            $query = $repository->getRepository('AppBundle:Post')->findAll();
        }else{

            /**
             * @var \AppBundle\Entity\Tag $tagView
             */
            $tagView = $repository->getRepository('AppBundle:Tag')->findOneByName($tag);
            $query = $tagView->getPosts();
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return new JsonResponse(['posts' => $pagination->getItems()]);
    }
}

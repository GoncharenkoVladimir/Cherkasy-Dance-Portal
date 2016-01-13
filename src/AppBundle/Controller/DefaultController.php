<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tag;
use AppBundle\Form\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Post;
use AppBundle\Form\Model\SearchModel;

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

        $word = new SearchModel();

        $form = $this->createForm(Search::class, $word);

        $form->add('submit', SubmitType::class, array('attr' => ['class' => 'search-btn']));


        $repo = $repository->getRepository('AppBundle:Post');

        if($request->getMethod() == Request::METHOD_POST){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $query = $repo->search($repo, $word);
            }
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return ['posts' => $pagination, 'tags' => $tags, 'tag'=> $tag, 'form_search' => $form->createView()];
    }

    /**
     * @Route("/infinity-scroll/scroll/{tag}", name="infinity-scroll", defaults={"tag" = 0}, options={"expose"=true})
     * @param Tag $tag
     * @return array
     */
    public function fffAction($tag, Request $request)
    {
        $repository = $this->getDoctrine();
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

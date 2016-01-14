<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Tag;
use AppBundle\Form\AddPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class AddPostController extends Controller
{
    /**
     * @Route("/add-post", name="add-post")
     * @Template()
     */
    public function addPostAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find(84);
        $post = new Post();
        $post->setAuthor($user);
        $post->setStatus('published');

        $form = $this->createForm(AddPost::class, $post);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST){
            if ($form->isValid()) {
                $arrayTags = explode(",", $post->getTagList());
                foreach ($arrayTags as $value){
                    $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->findOneByName($value);
                    if ($tag){
                        $post->addTag($tag);
                    }else{
                        $newTag = new Tag();
                        $newTag->setName($value);
                        $post->addTag($newTag);
                    }
                }

//                $post->upload();

                $em->persist($post);
                $em->flush();
                return $this->redirect($this->generateUrl('admin-posts', array('post' => $post)));
            }
        }
        return ['form' => $form->createView()];
    }
}

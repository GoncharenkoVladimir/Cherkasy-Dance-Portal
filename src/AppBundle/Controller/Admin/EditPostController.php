<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Tag;
use AppBundle\Form\AddPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\JsonResponse;

class EditPostController extends Controller
{
    /**
     * @Route("/edit-post/{id}", name="edit-post")
     * @Template()
     * @param $id
     * @return array
     */
    public function editPostAction(Request $request, $id)
    {
        $valMas = [];
        $post = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->find($id);
        $arrayTagsFromPost = $post->getTags()->getValues();

        /**
         * @var Tag $value
         */
        foreach($arrayTagsFromPost as $value){
            $valMas[] = $value->getName();
        }

        $post->setTagList(implode(",",$valMas));

        $form = $this->createForm(AddPost::class, $post);
        $form->handleRequest($request);

        if($request->getMethod() == Request::METHOD_POST) {
            if ($form->isValid()) {

                $arrayTags = explode(",", $post->getTagList());
                $res = array_diff($valMas, $arrayTags);
                $res2 = array_diff($arrayTags, $valMas);

                foreach($res as $value){
                    $tagRemove = $this->getDoctrine()->getRepository('AppBundle:Tag')->findOneByName($value);
                    if ($tagRemove){
                        $post->removeTag($tagRemove);
                    }
                }

                foreach($res2 as $value){
                    $tag = $this->getDoctrine()->getRepository('AppBundle:Tag')->findOneByName($value);
                    if ($tag){
                        $post->addTag($tag);
                    }else{
                        $newTag = new Tag();
                        $newTag->setName($value);
                        $post->addTag($newTag);
                    }
                }

                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('admin-posts', array('post' => $post)));
            }
        }

        return [
            'post' => $post,
            'form' => $form->createView()
        ];
    }
}

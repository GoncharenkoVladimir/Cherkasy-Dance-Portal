<?php

namespace AppBundle\Service;

class MainQuery
{
    public $query;

    public function getQuery($repository, $tag){
        if($tag == '0'){
            $this->query = $repository->getRepository('AppBundle:Post')->findAll();
        }else{

            /**
             * @var \AppBundle\Entity\Tag $tagView
             */
            $tagView = $repository->getRepository('AppBundle:Tag')->findOneByName($tag);
            $this->query = $tagView->getPosts();
        }

        return $this->query;
    }
}
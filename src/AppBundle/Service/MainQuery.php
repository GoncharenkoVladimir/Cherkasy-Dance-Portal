<?php

namespace AppBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;

class MainQuery
{
    protected $em;

    public function __construct( Registry $doctrine) {
        $this->em = $doctrine->getManager();
    }

    public function getQuery($tag){

        if($tag == '0'){
            $query = $this->em->getRepository('AppBundle:Post')->findAll();
        }else{

            /**
             * @var \AppBundle\Entity\Tag $tagView
             */
            $tagView = $this->em->getRepository('AppBundle:Tag')->findOneByName($tag);
            $query = $tagView->getPosts();
        }

        return $query;
    }
}
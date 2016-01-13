<?php


namespace AppBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class SearchModel
{

    /**
     * @var string
     *
     */
    protected $name;

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getName();
    }
}
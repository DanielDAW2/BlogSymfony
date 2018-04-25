<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=40)
     */
    private $tagname;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", mappedBy="tag")
     * @ORM\JoinTable(name="post_tags")
     */
    private $post;
    
    public function __construct() {
        $this->post = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTagname() {
        return $this->tagname;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTagname($tagname) {
        $this->tagname = $tagname;
    }

    public function __toString() {
        return $this->tagname;
    }
}

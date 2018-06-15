<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=60)
    */
    private $title;
    
    /**
     *  @ORM\Column(type="string", length=45)
     */
    private $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="post", cascade={"persist"})
     * @ORM\JoinTable(name="post_tags")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $tag;
    
    /**
     *  @ORM\Column(type="datetime")
     */
    private $data_creacio;
    
    /**
     *  @ORM\Column(type="datetime")
     */
    private $data_mod;
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post_id")
      * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $comments;
    
    public function getTags() {
        return $this->tag;
    }

    public function getData_creacio():string {
        $date = $this->data_creacio->format('d/m/Y');
        return $date;
    }

    public function getData_mod() {
        return $this->data_mod;
    }

    public function setTags($tag) {
        $this->tag = $tag;
    }

    public function setData_creacio($data_creacio) {
        $data_post = new \DateTime($data_creacio);
        $this->data_creacio = $data_post;
        
    }

    public function setData_mod($data_mod) {
        $data_post = new \DateTime($data_mod);
        $this->data_mod = $data_post;
    }

        public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->data_creacio = new \DateTime();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getUser() {
        return $this->user;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setUser(User $user_id) {
        $this->user = $user_id;
    }


}

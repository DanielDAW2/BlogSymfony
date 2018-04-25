<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    // add your own fields
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="id")
     */
    private $user_id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comment")
     */
    private $post_id;
    
    /**
     * @ORM\Column(type="string", length=150)
     */
    
    private $message;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $data;
    
    public function __construct() {
        $this->post_id = new ArrayCollection();
        $this->user_id = new ArrayCollection();
    }

    
    public function getId() {
        return $this->id;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function getPost_id() {
        return $this->post_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getData() {
        return $this->data;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function setPost_id($post_id) {
        $this->post_id = $post_id;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setData($data) {
        $this->data = $data;
    }


}

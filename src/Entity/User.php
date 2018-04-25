<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Post",mappedBy="user_id")
     * @ORM\OneToMany(targetEntity="App\Entity\Comment",mappedBy="user_id")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string",length=45, nullable=false, unique=true)
     */
    private $username;
    
    /**
     *
     * @ORM\Column(type="string",length=90, unique=true)
     */
    private $email;
    
    /**
     *
     * @ORM\Column(type="string",length=500)
     */
    private $passwd;
    
    /**
     *
     * @ORM\Column(type="string", nullable=true) 
     */
    private $lastlogin;
    
    /**
     * @ORM\Column(type="boolean",name="isActive")
     */
    private $isActive;
    
    /**
     * @ORM\Column(type="string")
     */
    private $role;
     
    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private $posts;
    
    
    function getPosts() {
        return $this->posts;
    }

    function setPosts($posts) {
        $this->posts = $posts;
    }

        
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getPasswd() {
        return $this->passwd;
    }

    function getLastlogin() {
        return $this->lastlogin;
    }

    function getIsActive() {
        return $this->isActive;
    }

    function getRole() {
        return $this->role;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPasswd($passwd) {
        $this->passwd = $passwd;
    }

    function setLastlogin($lastlogin) {
        $this->lastlogin = $lastlogin;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function __construct() {
        $this->isActive = true;
        $this->lastlogin =  "now()";
    }

    public function eraseCredentials() {
        
    }

    public function getPassword(): string {
        return $this->passwd;
    }

    public function getRoles() {
        return array($this->role);
    }

    public function getSalt() {
        
    }

}


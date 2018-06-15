<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\PostRepository;

class PostController extends Controller{
    
    private function serialize($posts)
    {
                   return array(
                        'Name' => $post->getTitle(),
                        'DateBorn' => $post->getData_creacio(),
                        'Content'=>$post->getContent(),
                  
                    );
                   return $allPost;
        }
 
    public function getAllPost()
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return  new JsonResponse($this->serialize($post));
    }
    
}

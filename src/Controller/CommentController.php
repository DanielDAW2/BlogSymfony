<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;

class CommentController extends Controller
{
    public function getCommentForm(Request $req)
    {
        $form = $this->createForm(CommentType::class);
        
        return $this->redirecToRoute("home");
    }
    
    public function setComment(Request $req)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
           $data = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $post = $this->getDoctrine()->getRepository(Post::class)->findOneBy(["id"=>$req->get("id")]);
           $comment->setMessage($data->getMessage());
           $comment->setUser_id($this->getUser());
           $comment->setPost_id($post);
           $comment->setData(new \Datetime());
           $em->persist($comment);
           
           $em->flush();
           
           return $this->redirectToRoute("viewPost",["id"=>$req->get("id")]);
        }
        return $this->redirectToRoute("home");
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;

class PostController extends Controller
{

    public function ListAllPost(PostRepository $repo)
    {
        $posts = $repo->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }    
    public function AddPost(Request $req)
    {
        $post = new Post();
        
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) 
            {

            $user = $this->getUser();
            $post->setData_creacio(date("Y-m-d"));
            $post->setData_mod(date("Y-m-d"));
            $post->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('home');
        }
        return $this->render("post/addpost.html.twig",['form'=>$form->createView()]);
    }
    public function DeletePost(Request $req, PostRepository $post_repo)
    {
        $id = $req->get('id');
        $post = [];
        $post = $post_repo->findOneBy(['id' => $id]);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();
        
        return $this->redirectToRoute("postindex");
    }
    
    public function EditPost(Request $req, PostRepository $post_repo, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        
        $form->handleRequest($req);
        $id = $req->get('id');
        $PostToEdit = $this->getDoctrine()->getManager()->getRepository(Post::class)->find($id);
        
        if ($form->isSubmitted() && $form->isValid()) 
            {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($PostToEdit);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render("post/addpost.html.twig",['form'=>$form->createView(),
                                                        'post'=>$PostToEdit]);
    }
    
    public function viewPost(Request $req)
    {
        $post = $this->getDoctrine()->getRepository(Post::class)->find($req->get('id'));
        return $this->render("post/viewPost.html.twig",['post'=>$post]);
    }
    public function viewPostByUser(Request $req)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(['user'=>$req->get('id')]);
        return $this->render('home/index.html.twig',['posts'=>$posts]);
    }
}

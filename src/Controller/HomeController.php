<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\PostRepository;
/**
 * Description of HomeController
 *
 * @author linux
 *
 */
class HomeController extends Controller{
    
    /**
     * @Route("/",name="home")
     */
    function home(PostRepository $post_repo)
    {
        $posts = [];
        $posts = $post_repo->findAll();
        return $this->render("home/index.html.twig",['posts' => $posts]);
    }
    
}

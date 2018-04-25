<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class UserController extends Controller
{
    
    public function show()
    {
        
        return $this->render("user/login.html.twig",
                [
                    'error'=>null,
                    'last_username'=>null
                ]);
    }
    

    public function login(Request $request, AuthenticationUtils $authUtils){
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();


        return $this->redirectToRoute("login");
                   
    }
      
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        //establishing default role and putting it active
        $user->setRole('ROLE_USER');
        $user->setIsActive(true);
        $user->setLastlogin("now()");
        
        
        //creating the form
        $form = $this->createForm(RegisterType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encoding password, first we get password in plaintext and then
    // we encode it.
            $password=$passwordEncoder->UserPasswordEncoderInterface($user, $user->getPasswd());
            $user->setPasswd($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            return $this->redirectToRoute('home');
        }
        //rendering form
        return $this->render('user/register.html.twig', array(
            'form' => $form->createView(),
        ));
         
    }
    
    
    public function validuser(Request $req, UserRepository $user_repo)
    {
        $usertest = $req->get("username");
        $em = $this->getDoctrine()->getManager();
        if($user_repo->findOneBy(['username'=>$usertest]))
        {
            return new Response(1);
        }
        else
        {
            return new Response(0);
        }
        
    }
    
    public function viewUsers()
    {
        
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/adminUsers.html.twig', ['posts'=>$users]);
    }


    public function logout(){
        $this->redirectToRoute("logout");
    }
    
    public function EditUser(Request $req)
    {
        $UserToEdit = $this->getDoctrine()->getManager()->getRepository(User::class)->find($req->get('id'));
        $form = $this->createForm(RegisterType::class, $UserToEdit);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) 
            {
                $data = $form->getData();
                dump($data);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($UserToEdit);
                $entityManager->flush();
                return $this->redirectToRoute('home');
            }
        return $this->render("user/edituser.html.twig",['form'=>$form->createView(),                                                    'user'=>$UserToEdit]);
    }
    public function DelUser(Request $req)
    {
        $this->getDocrine()->getRepository(User::class)->remove($req->get('id'));
        
        return $this->RedirectToRoute('ViewUsers');
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of user
 *
 * @author linux
 */
class UserController extends Controller {

    private function serialize(User $user) {
        return array(
            'nombre' => $user->getUsername(),
            'email' => $user->getEmail()
        );
    }

    public function getUsers($id = null) {
        if ($id) {
            $user = $this->getDoctrine()->getRepository(User::class)
                    ->findOneBy(['id' => $id]);
            if($user)
            {
                return new JsonResponse($this->serialize($user));
            }
            return new JsonResponse("No existe el usuario",404);
            
        } else {
            $users = $this->getDoctrine()->getRepository(User::class)->findall();
            $data = array('users' => array());
            foreach ($users as $user) {
                $data['users'][] = $this->serialize($user);
            }
            return new JSonResponse($data,200);
        }
    }

    public function deleteUser($id = null) {
        if ($id) {

            $em = $this->getDoctrine()->getEntityManager();
            $user = $em->getRepository(User::class)->findOneBy(['id' => $id]);
            $em->remove($user);
            $em->flush();
            //return new JsonResponse($this->serialize($user));
            return new JSonResponse("Borrado con exito",200);
        } else {
            return new JSonResponse("No se ha borrado nada",404);
        }
    }
    public function register(Request $request=null, UserPasswordEncoderInterface $passwordEncoder) {
        try {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $rol = $request->request->get('rol', 'ROLE_USER');
            $isActive = $request->request->get('isActive', true);
            if(!$username || !$password) {
                return new JsonResponse("Falta Usuario o contrasenyaa",404);
            }
            $newuser = new User();
            $newuser->setUsername($username);
            $password = $passwordEncoder->encodePassword($newuser, $password);
            $newuser->setPassword($password);
            $newuser->setRol($rol);
            $newuser->setIsActive($isActive);
            $newuser->setLastlogin(new \DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newuser);
            $manager->flush();
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 204);
        }
        return new JsonResponse($this->serialize($newuser));
    }
    
        public function updateUser(Request $request, string $username, UserPasswordEncoderInterface $passwordEncoder) {
        
            $user = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findOneBy([ 'username' => $username ]);
            if(!$user) {
                return new JsonResponse("No existe el usuario",404);
            }
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $rol = $request->request->get('rol');
            $isActive = $request->request->get('isActive');
            if($username != null) {
                $user->setUsername($username);
            }
            if($password != null) {
                $password = $passwordEncoder->encodePassword($user, $password);
                $user->setPassword($password);
            }
            if($rol != null) {
                $user->setRol($rol);
            }
            if($isActive != null) {
                $user->setIsActive($isActive);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
        
        return new JsonResponse($this->serialize($user));
    }


}
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
            return new JSonResponse("se ha borrado",200);
        } else {
            return new JSonResponse("no see ha borrado",200);
        }
    }


}
<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MemberDeleteController extends AbstractController
{
    /**
     * @Route("/user/delete", name="app_user_delete", methods={"GET", "POST"})
     */
    public function deleteUser(Request $request, UserRepository $userRepository): Response
    {
        $member_info = $this->getUser();
        $member_name =$member_info->getUsername();
        return $this->render('delete_user.html.twig',
            [  'member_name' =>$member_name]);
    }

    /**
     * @Route("/user/deleted", name="app_user_deleted", methods={"GET", "POST"})
     */
    public function deletedUser(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $userRepository->remove($user);
        return $this->render('logout.html.twig');
    }
}
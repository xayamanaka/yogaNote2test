<?php

namespace App\Controller;

use App\Entity\MemberPose;
use App\Form\MemberPoseType;

use App\Repository\BasePoseRepository;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\MemberPoseRepository;


use Doctrine\ORM\EntityManagerInterface;

class MemberAddPoseController extends AbstractController
{
    /**
     * @Route("member/pose/add", name="app_member_pose_add", methods={"GET", "POST"})
     */
    public function add(BasePoseRepository $basePoseRepository, SessionInterface $session, Request $request): Response
    {
        $member_info = $this->getUser();
        $member_name =$member_info->getUsername();
        $allPose=$basePoseRepository->findAll();

        return $this->render('member_pose/add.html.twig',
            [  'base_poses' => $allPose,'member_name' =>$member_name]);
    }
    /**
     * @Route("member/pose/added/{id}", name="app_yoga_added", methods={"GET", "POST"})
     */
    public function added(int $id,BasePoseRepository $basePoseRepository, MemberPoseRepository $memberPoseRepository,SessionInterface $session, Request $request):Response
    {
        $user= $this->getUser();
        $user_name = $user->getUsername();
        $add_pose=$basePoseRepository->findBy(['id'=>$id]);
        //dd($add_pose);
        $add_pose_name=$add_pose[0]->getBasePoseName();
        $add_pose_image=$add_pose[0]->getBasePoseImage();
        $add_pose_category=$add_pose[0]->getBasePoseCategory();
        //dd($add_pose_name);
        //$add_pose_name=$add_pose->base_pose_image();
        $memberPose = new MemberPose();
        $memberPose->setMemberName($user_name);
        $memberPose->setMemberPoseName($add_pose_name);
        $memberPose->setMemberPoseImage($add_pose_image);


        $memberPoseRepository->add($memberPose);
        return $this->redirectToRoute('app_member_pose_index', [], Response::HTTP_SEE_OTHER);
    }

}
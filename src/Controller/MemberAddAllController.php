<?php

namespace App\Controller;

use App\Entity\MemberPose;
use App\Form\MemberPoseType;
use App\Repository\MemberPoseRepository;
use App\Repository\BasePoseRepository;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


use Doctrine\ORM\EntityManagerInterface;

class MemberAddAllController extends AbstractController
{
    /**
     * @Route("/member/add/all", name="app_member_add_all", methods={"GET", "POST"})
     */
    public function add(BasePoseRepository $basePoseRepository, SessionInterface $session, Request $request, MemberPoseRepository $memberPoseRepository): Response
    {
        $user_name = $this->getUser();
        //dd($user_name);
        $user_name = $user_name->getUsername();
        $s = 0;
        for ($t = 0; $t < 1000; $t++) {
            $first = $basePoseRepository->find($s);
            if ($first) {
                $second = clone $first;
                $pose_category = $second->getBasePoseCategory();
                if ($pose_category === 'ashtanga') {

                    //$second->setUsername($user_name);
                    $pose_name = $second->getBasePoseName();
                    $pose_image = $second->getBasePoseImage();
                    //$second->setUserName('nice');
                    $keyword = $memberPoseRepository->findBy(['member_name' => $user_name]);
                    //dd($keyword);
                    $array_count = count($keyword);
                    $count = 0;

                    for ($t = 0; $t < $array_count; $t++) {
                        $check = $keyword[$t]->getMemberPoseName();
                        if ($pose_name == $check) {
                            $count++;
                        }
                    }
                    if ($count === 0) {
                        $second = new MemberPose();
                        $second->setMemberName($user_name);
                        $second->setMemberPoseName($pose_name);
                        $second->setMemberPoseImage($pose_image);
                        $second->setMemberPoseMemo('please input');
                        $memberPoseRepository->add($second);
                    }
                }
            }
            $s++;
        }
        return $this->redirectToRoute('app_member_pose_index', [], Response::HTTP_SEE_OTHER);
    }
}
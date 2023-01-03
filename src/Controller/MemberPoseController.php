<?php

namespace App\Controller;

use App\Entity\MemberPose;
use App\Form\MemberPoseType;
use App\Repository\MemberPoseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;

/**
 * @Route("/member/pose")
 */
class MemberPoseController extends AbstractController
{
    /**
     * @Route("/", name="app_member_pose_index", methods={"GET"})
     */
    public function index(MemberPoseRepository $memberPoseRepository): Response
    {
        $member_info = $this->getUser();
        $member_name =$member_info->getUsername();
        return $this->render('member_pose/index.html.twig', [
            'member_poses' => $memberPoseRepository->findBy(['member_name'=>$member_name]),'member_name' =>$member_name
        ]);
    }

    /**
     * @Route("/new", name="app_member_pose_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MemberPoseRepository $memberPoseRepository): Response
    {
        $memberPose = new MemberPose();
        $form = $this->createForm(MemberPoseType::class, $memberPose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $member_pose_name=$form['member_pose_name']->getData();
            $uploadedFile = $form['member_pose_image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($member_pose_name).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $memberPose->setMemberPoseImage($newFilename);
            $memberPoseRepository->add($memberPose);
            return $this->redirectToRoute('app_member_pose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('member_pose/new.html.twig', [
            'member_pose' => $memberPose,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_member_pose_show", methods={"GET"})
     */
    public function show(MemberPose $memberPose): Response
    {
        return $this->render('member_pose/show.html.twig', [
            'member_pose' => $memberPose,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_member_pose_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MemberPose $memberPose, MemberPoseRepository $memberPoseRepository): Response
    {
        $form = $this->createForm(MemberPoseType::class, $memberPose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memberPoseRepository->add($memberPose);
            return $this->redirectToRoute('app_member_pose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('member_pose/edit.html.twig', [
            'member_pose' => $memberPose,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_member_pose_delete", methods={"POST"})
     */
    public function delete(Request $request, MemberPose $memberPose, MemberPoseRepository $memberPoseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memberPose->getId(), $request->request->get('_token'))) {
            $memberPoseRepository->remove($memberPose);
        }

        return $this->redirectToRoute('app_member_pose_index', [], Response::HTTP_SEE_OTHER);
    }
}

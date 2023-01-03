<?php

namespace App\Controller;

use App\Entity\BasePose;
use App\Form\BasePoseType;
use App\Form\EditBasePoseType;
use App\Form\EditPhotoBasePoseType;
use App\Repository\BasePoseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;

/**
 * @Route("/base/pose")
 */
class BasePoseController extends AbstractController
{
    /**
     * @Route("/", name="app_base_pose_index", methods={"GET"})
     */
    public function index(BasePoseRepository $basePoseRepository): Response
    {
        return $this->render('base_pose/index.html.twig', [
            'base_poses' => $basePoseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_base_pose_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BasePoseRepository $basePoseRepository): Response
    {
        $basePose = new BasePose();
        $form = $this->createForm(BasePoseType::class, $basePose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $base_pose_name=$form['base_pose_name']->getData();
            $uploadedFile = $form['base_pose_image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($base_pose_name).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $basePose->setBasePoseImage($newFilename);
            $basePoseRepository->add($basePose);

            return $this->redirectToRoute('app_base_pose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('base_pose/new.html.twig', [
            'base_pose' => $basePose,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_base_pose_show", methods={"GET"})
     */
    public function show(BasePose $basePose): Response
    {
        return $this->render('base_pose/show.html.twig', [
            'base_pose' => $basePose,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_base_pose_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BasePose $basePose, BasePoseRepository $basePoseRepository): Response
    {
        $form = $this->createForm(EditBasePoseType::class, $basePose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $basePoseRepository->add($basePose);
            return $this->redirectToRoute('app_base_pose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('base_pose/edit.html.twig', [
            'base_pose' => $basePose,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit/photo", name="app_base_pose_edit_photo", methods={"GET", "POST"})
     */
    public function editPhoto(Request $request, BasePose $basePose, BasePoseRepository $basePoseRepository): Response
    {
        $form = $this->createForm(EditPhotoBasePoseType::class, $basePose);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $base_pose_name = $basePose->getBasePoseName();
            $uploadedFile = $form['base_pose_image']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($base_pose_name).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $basePose->setBasePoseImage($newFilename);
            $basePoseRepository->add($basePose);
            $basePoseRepository->add($basePose);
            return $this->redirectToRoute('app_base_pose_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('base_pose/edit.html.twig', [
            'base_pose' => $basePose,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_base_pose_delete", methods={"POST"})
     */
    public function delete(Request $request, BasePose $basePose, BasePoseRepository $basePoseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$basePose->getId(), $request->request->get('_token'))) {
            $basePoseRepository->remove($basePose);
        }

        return $this->redirectToRoute('app_base_pose_index', [], Response::HTTP_SEE_OTHER);
    }

}

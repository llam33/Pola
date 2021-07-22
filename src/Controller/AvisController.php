<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AvisController extends AbstractController
{
    /**
     * @Route("/avis", name="avis" , methods= {"GET"})
     */

    public function index(AvisRepository $avisRepository): Response
    {
        $suggestions= $avisRepository->findAll();
        return $this->render('avis/index.html.twig', [
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER", statusCode= 401, message= "You have to be logged-in to access this ressource")
     * @Route("/create", name="avis_create" , methods={"GET","POST"})
     */

    public function create(Request $request): Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->security->getUser();
            $avis->setAuthor($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avis);
            $entityManager->flush();

            return $this->redirectToRoute('avis');
        }

        return $this->render('avis/create.html.twig', [
            'avis' => $avis,
            'form' => $form->createView(),
        ]);
    }

    /**
     *  @IsGranted("ROLE_USER", statusCode= 401, message= "You have to be logged-in to access this ressource")
     * @Route("/{id}/edit", name="avis_edit" , methods= {"GET","POST"})
     */


    public function edit(Avis $avis, Request $request)
    {
        $user = $this->security->getUser();
        if ($user === $avis->getAuthor()) {
            $form = $this->createForm(AvisType::class, $avis);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Your __entity__ has been updated successfully.');

                return $this->redirectToRoute('avis');
            }
            return $this->render('avis/edit.html.twig', [
                'avis' => $avis,
                'form' => $form->createView(),

            ]);
        }
        return $this->render('common/error.html.twig', [
            'error' => 401,
            'message' => 'Unauthorized access',
        ]);
    }

    /**
     *  @IsGranted("ROLE_USER", statusCode= 401, message= "You have to be logged-in to access this ressource")
     * @Route("/{id}/delete", name="avis_delete" , methods=  {"POST"})
     */

    public function delete(Request $request, Avis $avis): Response
    {
        $user = $this->security->getUser();
        if ($user === $avis->getAuthor()) {
            if ($this->isCsrfTokenValid('delete' . $avis->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($avis);
                $entityManager->flush();
            }

            return $this->redirectToRoute('avis');
        }

        return $this->render('common/error.html.twig', [
            'error' => 401,
            'message' => 'Unauthorized access',
        ]);
    }
}

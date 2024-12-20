<?php

namespace App\Controller;

use App\Entity\Respuesta;
use App\Entity\Pregunta;
use App\Form\RespuestaType;
use App\Repository\RespuestaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RespuestaController extends AbstractController
{
    #[Route('/preguntas/{id}/respuestas', name: 'respuesta_list')]
    public function list(Pregunta $pregunta, RespuestaRepository $respuestaRepository): Response
    {
        $respuestas = $respuestaRepository->findBy(['pregunta' => $pregunta]);

        return $this->render('respuesta/list.html.twig', [
            'pregunta' => $pregunta,
            'respuestas' => $respuestas,
        ]);
    }

    #[Route('/preguntas/{id}/responder', name: 'respuesta_create')]
    public function create(Pregunta $pregunta, Request $request, EntityManagerInterface $em): Response
    {
        $respuesta = new Respuesta();
        $respuesta->setPregunta($pregunta);
        $respuesta->setUsuario($this->getUser());

        $form = $this->createForm(RespuestaType::class, $respuesta);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($respuesta);
            $em->flush();

            return $this->redirectToRoute('respuesta_list', ['id' => $pregunta->getId()]);
        }

        return $this->render('respuesta/create.html.twig', [
            'form' => $form->createView(),
            'pregunta' => $pregunta,
        ]);
    }
}


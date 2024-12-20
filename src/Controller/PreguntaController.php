<?php

namespace App\Controller;

use App\Entity\Pregunta;
use App\Form\PreguntaType;
use App\Repository\PreguntaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreguntaController extends AbstractController
{
    #[Route('/pregunta', name: 'pregunta_user')]
    public function preguntaUser(PreguntaRepository $preguntaRepository): Response
    {
        return $this->render('pregunta/actual.html.twig');
    }
    
    #[Route('/preguntas', name: 'pregunta_index')]
    public function index(PreguntaRepository $preguntaRepository): Response
    {
        // Obtener todas las preguntas de la base de datos
        $preguntas = $preguntaRepository->findAll();

        return $this->render('pregunta/index.html.twig', [
            'preguntas' => $preguntas,
        ]);
    }

    #[Route('/preguntas/nueva', name: 'pregunta_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // Crear una nueva instancia de Pregunta
        $pregunta = new Pregunta();
        
        // Crear el formulario para la nueva pregunta
        $form = $this->createForm(PreguntaType::class, $pregunta);

        // Manejar la solicitud del formulario
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persistir la nueva pregunta en la base de datos
            $em->persist($pregunta);
            $em->flush();

            // Redirigir a la lista de preguntas después de crearla
            return $this->redirectToRoute('pregunta_index');
        }

        // Renderizar el formulario de creación
        return $this->render('pregunta/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/preguntas/{id}/editar', name: 'pregunta_edit')]
    public function edit(Pregunta $pregunta, Request $request, EntityManagerInterface $em): Response
    {
        // Crear el formulario con la pregunta existente
        $form = $this->createForm(PreguntaType::class, $pregunta);

        // Manejar la solicitud del formulario
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persistir los cambios en la base de datos
            $em->flush();

            // Redirigir a la lista de preguntas después de editar
            return $this->redirectToRoute('pregunta_index');
        }

        // Renderizar el formulario de edición
        return $this->render('pregunta/edit.html.twig', [
            'form' => $form->createView(),
            'pregunta' => $pregunta,
        ]);
    }

    #[Route('/preguntas/{id}/eliminar', name: 'pregunta_delete', methods: ['POST'])]
    public function delete(Pregunta $pregunta, EntityManagerInterface $em): Response
    {
        // Eliminar la pregunta de la base de datos
        $em->remove($pregunta);
        $em->flush();

        // Redirigir a la lista de preguntas después de eliminarla
        return $this->redirectToRoute('pregunta_index');
    }
}


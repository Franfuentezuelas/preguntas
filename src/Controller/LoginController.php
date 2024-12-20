<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        // Verificar si el usuario está autenticado
        if ($this->getUser()) {
            return $this->redirectToRoute('app_pagina'); // Redirige a la página de administración
        }
        // Si no está autenticado, mostrar la página de inicio de sesión
        return $this->render('login/index.html.twig');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Este método puede permanecer vacío. Symfony gestiona el cierre de sesión automáticamente.
        throw new \LogicException('Este método será interceptado por la configuración de cierre de sesión en security.yaml.');
    }
    #[Route('/cargarpagina', name: 'app_pagina')]
    public function cargarPagina(): Response
    {
        // Verificar si el usuario está autenticado
        if ($this->getUser()) {
            $roles=$this->getUser()->getRoles()[0]; // Obtener el primer rol del usuario

        
            // Verificar si el usuario tiene el rol 'ROLE_ADMIN'
            if ($roles=='ROLE_ADMIN' ) {
                return $this->redirectToRoute('pregunta_index'); // Redirige a la página de administración
            }

            // Verificar si el usuario tiene el rol 'ROLE_USER'
            if ($roles=='ROLE_USER') {
                return $this->redirectToRoute('pregunta_user'); // Redirige a la página de preguntas
            }
        }
    }
}


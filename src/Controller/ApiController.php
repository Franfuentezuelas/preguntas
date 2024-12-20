<?php

namespace App\Controller;

use App\Repository\PreguntaRepository;
use App\Repository\RespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/estadisticas/preguntas', name: 'api_pregunta_estadisticas', methods: ['GET'])]
    public function getPreguntaEstadisticas(PreguntaRepository $preguntaRepository): JsonResponse
    {
        $totalPreguntas = $preguntaRepository->count([]);
        return $this->json([
            'total_preguntas' => $totalPreguntas,
        ]);
    }

    #[Route('/api/estadisticas/respuestas', name: 'api_respuesta_estadisticas', methods: ['GET'])]
    public function getRespuestaEstadisticas(RespuestaRepository $respuestaRepository): JsonResponse
    {
        $totalRespuestas = $respuestaRepository->count([]);
        return $this->json([
            'total_respuestas' => $totalRespuestas,
        ]);
    }

    #[Route('/api/pregunta/activa', name: 'api_pregunta_activa', methods: ['GET'])]
    public function preguntaActiva(PreguntaRepository $preguntaRepository): JsonResponse
    {
        $pregunta = $preguntaRepository->findActive();
    
        if (!$pregunta) {

            return $this->json(['message' => 'No hay preguntas activas'], 404);
        }
    
        return $this->json($pregunta);
    }
    

    #[Route('/api/pregunta/estadistica/{id}', name: 'api_pregunta_estadistica', methods: ['GET'])]
    public function estadistica(int $id, RespuestaRepository $respuestaRepository): JsonResponse
    {
        // Definir las opciones predeterminadas
        $opcionesPredeterminadas = ['option1', 'option2', 'option3', 'option4'];
        
        // Obtener las estadísticas de las respuestas
        $estadisticas = $respuestaRepository->countRespuestasPorOpcion($id);
        
        // Crear un array para almacenar las respuestas con valor 0 por defecto
        $respuestasConCero = array_fill_keys($opcionesPredeterminadas, 0);

        // Mapear las estadísticas a las opciones predeterminadas
        //foreach ($estadisticas as $estadistica) {
        //    $respuestasConCero[$estadistica['opcion']] = $estadistica['cantidad'];
        //}

        return $this->json($estadisticas);
    }
    
}


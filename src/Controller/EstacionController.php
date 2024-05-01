<?php

namespace App\Controller;

use App\Entity\Estacion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class EstacionController extends AbstractController
{
    public function estaciones(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET")) {
            $estaciones = $this->getDoctrine()
                ->getRepository(Estacion::class)
                ->findAll();

            $estaciones = $serializer->serialize(
                $estaciones,
                "json",
                ["groups" => ["estacion"]]
            );

            return new Response($estaciones);
        }

        // Faltaría asignar una ruta a la estación con findOneBy
        // La selección de la ruta se podría hacer a través de la petición o dentro del json con los datos de la nueva estación
        if ($request->isMethod("POST")) {
            $bodyData = $request->getContent();
            $estacion = $serializer->deserialize(
                $bodyData,
                Estacion::class,
                "json"
            );

            $this->getDoctrine()->getManager()->persist($estacion);
            $this->getDoctrine()->getManager()->flush();

            $estacion = $serializer->serialize(
                $estacion, 
                "json", 
                ["groups" => ["estacion"]]
            );
            
            return new Response($estacion);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function estacion(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $estacion = $this->getDoctrine()
            ->getRepository(Estacion::class)
            ->findOneBy(["id" => $id]);

        if ($request->isMethod("GET")) {
            $estacion = $serializer->serialize(
                $estacion,
                "json",
                ["groups" => ["estacion"]]
            );

            return new Response($estacion);
        }

        if ($request->isMethod("PUT")) {
            if (!empty($estacion)) {
                $bodyData = $request->getContent();
                $estacion = $serializer->deserialize(
                    $bodyData,
                    Estacion::class,
                    "json",
                    ["object_to_populate" => $estacion]
                );
                
                $this->getDoctrine()->getManager()->persist($estacion);
                $this->getDoctrine()->getManager()->flush();

                $estacion = $serializer->serialize(
                    $estacion,
                    "json",
                    ["groups" => ["estacion"]]
                );

            return new Response($estacion);
            }

            return new JsonResponse(["msg" => "Estación no encontrada"], 404);
        }

        if ($request->isMethod("DELETE")) {
            $deletedEstacion = clone $estacion;
            $this->getDoctrine()->getManager()->remove($estacion);
            $this->getDoctrine()->getManager()->flush();
            
            $deletedEstacion = $serializer->serialize(
                $deletedEstacion, 
                "json", 
                ["groups" => ["estacion"]]
            );

            return new Response($deletedEstacion);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }
}

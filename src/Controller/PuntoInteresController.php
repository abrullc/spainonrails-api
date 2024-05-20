<?php

namespace App\Controller;

use App\Entity\PuntoInteres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PuntoInteresController extends AbstractController
{
    public function puntosInteres(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET")) {
            $puntosInteres = $this->getDoctrine()
                ->getRepository(PuntoInteres::class)
                ->findAll();

            $puntosInteres = $serializer->serialize(
                $puntosInteres,
                "json",
                ["groups" => ["puntoInteres"]]
            );

            return new Response($puntosInteres);
        }

        
        // Faltaría asignar una estación al punto de interés con findOneBy
        // La selección de la estación se podría hacer a través de la petición
        if ($request->isMethod("POST")) {
            $bodyData = $request->getContent();
            $puntoInteres = $serializer->deserialize(
                $bodyData,
                puntoInteres::class,
                "json"
            );

            $this->getDoctrine()->getManager()->persist($puntoInteres);
            $this->getDoctrine()->getManager()->flush();

            $puntoInteres = $serializer->serialize(
                $puntoInteres, 
                "json", 
                ["groups" => ["puntoInteres"]]
            );
            
            return new Response($puntoInteres);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function puntoInteres(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $puntoInteres = $this->getDoctrine()
            ->getRepository(PuntoInteres::class)
            ->findOneBy(["id" => $id]);

        if ($request->isMethod("GET")) {
            $puntoInteres = $serializer->serialize(
                $puntoInteres,
                "json",
                ["groups" => ["puntoInteres"]]
            );

            return new Response($puntoInteres);
        }

        if ($request->isMethod("PUT")) {
            if (!empty($puntoInteres)) {
                $bodyData = $request->getContent();
                $puntoInteres = $serializer->deserialize(
                    $bodyData,
                    PuntoInteres::class,
                    "json",
                    ["object_to_populate" => $puntoInteres]
                );
                
                $this->getDoctrine()->getManager()->persist($puntoInteres);
                $this->getDoctrine()->getManager()->flush();

                $puntoInteres = $serializer->serialize(
                    $puntoInteres,
                    "json",
                    ["groups" => ["puntoInteres"]]
                );

            return new Response($puntoInteres);
            }

            return new JsonResponse(["msg" => "Punto de interés no encontrado"], 404);
        }

        if ($request->isMethod("DELETE")) {
            $deletedPuntoInteres = clone $puntoInteres;
            $this->getDoctrine()->getManager()->remove($puntoInteres);
            $this->getDoctrine()->getManager()->flush();
            
            $deletedPuntoInteres = $serializer->serialize(
                $deletedPuntoInteres, 
                "json", 
                ["groups" => ["puntoInteres"]]
            );

            return new Response($deletedPuntoInteres);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }
}

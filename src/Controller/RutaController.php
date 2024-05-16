<?php

namespace App\Controller;

use App\Entity\Estacion;
use App\Entity\Ruta;
use App\Entity\Tren;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class RutaController extends AbstractController
{
    public function rutas(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET")) {
            $rutas = $this->getDoctrine()
                ->getRepository(Ruta::class)
                ->findAll();

            $rutas = $serializer->serialize(
                $rutas,
                "json",
                ["groups" => ["ruta", "tren"]]
            );

            return new Response($rutas);
        }

        if ($request->isMethod("POST")) {
            $bodyData = $request->getContent();
            $ruta = $serializer->deserialize(
                $bodyData,
                Ruta::class,
                "json"
            );

            $this->getDoctrine()->getManager()->persist($ruta);
            $this->getDoctrine()->getManager()->flush();

            $ruta = $serializer->serialize(
                $ruta, 
                "json", 
                ["groups" => ["ruta"]]
            );
            
            return new Response($ruta);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function ruta(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $ruta = $this->getDoctrine()
            ->getRepository(Ruta::class)
            ->findOneBy(["id" => $id]);

        if ($request->isMethod("GET")) {
            $ruta = $serializer->serialize(
                $ruta,
                "json",
                ["groups" => ["ruta", "tren"]]
            );

            return new Response($ruta);
        }

        if ($request->isMethod("PUT")) {
            if (!empty($ruta)) {
                $bodyData = $request->getContent();
                $ruta = $serializer->deserialize(
                    $bodyData,
                    Ruta::class,
                    "json",
                    ["object_to_populate" => $ruta]
                );
                
                $this->getDoctrine()->getManager()->persist($ruta);
                $this->getDoctrine()->getManager()->flush();

                $ruta = $serializer->serialize(
                    $ruta,
                    "json",
                    ["groups" => ["ruta", "tren"]]
                );

                return new Response($ruta);
            }

            return new JsonResponse(["msg" => "Ruta no encontrada"], 404);
        }

        if ($request->isMethod("DELETE")) {
            $deletedRuta = clone $ruta;
            $this->getDoctrine()->getManager()->remove($ruta);
            $this->getDoctrine()->getManager()->flush();
            
            $deletedRuta = $serializer->serialize(
                $deletedRuta, 
                "json", 
                ["groups" => ["ruta", "tren"]]
            );

            return new Response($deletedRuta);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function trenRuta(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $ruta = $this->getDoctrine()
            ->getRepository(Ruta::class)
            ->findOneBy(["id" => $id]);
        
        $trenRuta = $ruta->getTren();

        if ($request->isMethod("GET")) {
            $trenRuta = $serializer->serialize(
                $trenRuta,
                "json",
                ["groups" => ["tren"]]
            );

            return new Response($trenRuta);
        }

        if ($request->isMethod("DELETE")) {
            $ruta->setTren(null);

            $this->getDoctrine()->getManager()->persist($ruta);
            $this->getDoctrine()->getManager()->flush();

            $ruta = $serializer->serialize(
                $ruta,
                "json",
                ["groups" => ["ruta", "tren"]]
            );

            return new Response($ruta);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function addTrenRuta(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("POST")) {
            $idRuta = $request->get("idRuta");
            $idTren = $request->get("idTren");

            $ruta = $this->getDoctrine()
                ->getRepository(Ruta::class)
                ->findOneBy(["id" => $idRuta]);

            if (!empty($ruta)) {

                $tren = $this->getDoctrine()
                    ->getRepository(Tren::class)
                    ->findOneBy(["id" => $idTren]);
                
                $ruta->setTren($tren);
                
                $this->getDoctrine()->getManager()->persist($ruta);
                $this->getDoctrine()->getManager()->flush();

                $ruta = $serializer->serialize(
                    $ruta,
                    "json",
                    ["groups" => ["ruta", "tren"]]
                );

                return new Response($ruta);
            }

            return new JsonResponse(["msg" => "Ruta no encontrada"], 404);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function estacionesRuta(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $ruta = $this->getDoctrine()
            ->getRepository(Ruta::class)
            ->findOneBy(["id" => $id]);
        
        if (!empty($ruta))
        {
            if ($request->isMethod("GET")) {
                $estacionesRuta = $ruta->getEstacion();
    
                $estacionesRuta = $serializer->serialize(
                    $estacionesRuta,
                    "json",
                    ["groups" => ["estacion"]]
                );
    
                return new Response($estacionesRuta);
            }

            return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
        }

        return new JsonResponse(["msg" => "Estación no encontrada"], 404);
    }

    public function estacionRuta(SerializerInterface $serializer, Request $request)
    {
        $idRuta = $request->get("idRuta");

        $ruta = $this->getDoctrine()
            ->getRepository(Ruta::class)
            ->findOneBy(["id" => $idRuta]);
        
        if (!empty($ruta))
        {
            $idEstacion = $request->get("idEstacion");

            $estacion = $this->getDoctrine()
                ->getRepository(Estacion::class)
                ->findOneBy(["id" => $idEstacion]);

            if (!empty($estacion))
            {
                $estacionesRuta = $ruta->getEstacion();

                if ($request->isMethod("POST")) {
                    $estacionesRuta[] = $estacion;
                    $ruta->setEstacion($estacionesRuta);
                    
                    $this->getDoctrine()->getManager()->persist($ruta);
                    $this->getDoctrine()->getManager()->flush();
                    
                    $ruta = $serializer->serialize(
                        $ruta,
                        "json",
                        ["groups" => ["ruta"]]
                    );
                    
                    return new Response($ruta);
                }

                if ($request->isMethod("DELETE")) {
                    $updatedEstacionesRuta = [];
                    foreach ($estacionesRuta as $estacionRuta)
                    {
                        if ($estacionRuta != $estacion)
                        {
                            $updatedEstacionesRuta[] = $estacionRuta;
                        }
                    }

                    $ruta->setEstacion($updatedEstacionesRuta);
                    
                    $this->getDoctrine()->getManager()->persist($ruta);
                    $this->getDoctrine()->getManager()->flush();
                    
                    $ruta = $serializer->serialize(
                        $ruta,
                        "json",
                        ["groups" => ["ruta"]]
                    );
                    
                    return new Response($ruta);
                }
        
                return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
            }

            return new JsonResponse(["msg" => "Ruta no encontrada"], 404);
        }

        return new JsonResponse(["msg" => "Estación no encontrada"], 404);
    }
}

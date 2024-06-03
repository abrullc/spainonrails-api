<?php

namespace App\Controller;

use App\Entity\Pasaje;
use App\Entity\Ruta;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PasajeController extends AbstractController
{
    public function pasajes(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET"))
        {
            $pasajes = $this->getDoctrine()
                ->getRepository(Pasaje::class)
                ->findAll();

            $pasajes = $serializer->serialize(
                $pasajes,
                "json",
                ["groups" => ["pasaje", "rutaPasaje", "usuario"]]
            );

            return new Response($pasajes);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function pasaje(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $pasaje = $this->getDoctrine()
            ->getRepository(Pasaje::class)
            ->findOneBy(["id" => $id]);
        
        if (!empty($pasaje))
        {
            if ($request->isMethod("GET"))
            {
                $pasaje = $serializer->serialize(
                    $pasaje,
                    "json",
                    ["groups" => ["pasaje", "rutaPasaje", "usuario"]]
                );
    
                return new Response($pasaje);
            }
    
            if ($request->isMethod("PUT"))
            {
                $bodyData = $request->getContent();
                $pasaje = $serializer->deserialize(
                    $bodyData,
                    Pasaje::class,
                    "json",
                    ["object_to_populate" => $pasaje]
                );
                
                $this->getDoctrine()->getManager()->persist($pasaje);
                $this->getDoctrine()->getManager()->flush();
                
                $pasaje = $serializer->serialize(
                    $pasaje,
                    "json",
                    ["groups" => ["pasaje", "rutaPasaje", "usuario"]]
                );
                
                return new Response($pasaje);
            }
    
            if ($request->isMethod("DELETE"))
            {
                $deletedPasaje = clone $pasaje;
                $this->getDoctrine()->getManager()->remove($pasaje);
                $this->getDoctrine()->getManager()->flush();
                
                $deletedPasaje = $serializer->serialize(
                    $deletedPasaje, 
                    "json", 
                    ["groups" => ["pasaje", "ruta", "usuario"]]
                );
    
                return new Response($deletedPasaje);
            }
    
            return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
        }

        return new JsonResponse(["msg" => "Pasaje no encontrado"], 404);
    }

    public function pasajesRuta(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $ruta = $this->getDoctrine()
            ->getRepository(Ruta::class)
            ->findOneBy(["id" => $id]);

        if (!empty($ruta))
        {
            if ($request->isMethod("GET"))
            {
                $pasajesRutas = $this->getDoctrine()
                    ->getRepository(Pasaje::class)
                    ->findBy(["ruta" => $ruta]);
                    
                $pasajesRutas = $serializer->serialize(
                    $pasajesRutas,
                    "json",
                    ["groups" => ["pasajeRuta", "usuario"]]
                );
        
                return new Response($pasajesRutas);
            }

            if ($request->isMethod("POST"))
            {
                $bodyData = $request->getContent();
                $pasajeRuta = $serializer->deserialize(
                    $bodyData,
                    Pasaje::class,
                    "json"
                );

                $pasajeRuta->setRuta($ruta);

                $this->getDoctrine()->getManager()->persist($pasajeRuta);
                $this->getDoctrine()->getManager()->flush();

                $pasajeRuta = $serializer->serialize(
                    $pasajeRuta, 
                    "json", 
                    ["groups" => ["pasajeRuta", "usuario"]]
                );
                    
                return new Response($pasajeRuta);
            }
            
            return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
        }

        return new JsonResponse(["msg" => "Ruta no encontrada"], 404);
    }

    public function pasajesUsuario(SerializerInterface $serializer, Request $request)
    {   
        if ($request->isMethod("GET"))
        {
            $id = $request->get("id");

            $usuario = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findOneBy(["id" => $id]);
            
            if (!empty($usuario))
            {
                $pasajesUsuario = $this->getDoctrine()
                    ->getRepository(Pasaje::class)
                    ->findBy(["usuario" => $usuario]);
                
                $pasajesUsuario = $serializer->serialize(
                    $pasajesUsuario,
                    "json",
                    ["groups" => ["pasajeUsuario", "rutaPasaje"]]
                );
    
                return new Response($pasajesUsuario);
            }

            return new JsonResponse(["msg" => "Usuario no encontrado"], 404);
        }
        
        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function addPasajeUsuario(SerializerInterface $serializer, Request $request)
    {
        $idPasaje = $request->get("idPasaje");

        $pasaje = $this->getDoctrine()
            ->getRepository(Pasaje::class)
            ->findOneBy(["id" => $idPasaje]);
        
        if (!empty($pasaje))
        {
            $idUsuario = $request->get("idUsuario");

            $usuario = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findOneBy(["id" => $idUsuario]);
            
            if (!empty($usuario))
            {
                if ($request->isMethod("POST"))
                {
                    $pasaje->setUsuario($usuario);

                    $this->getDoctrine()->getManager()->persist($pasaje);
                    $this->getDoctrine()->getManager()->flush();

                    $pasaje = $serializer->serialize(
                        $pasaje, 
                        "json", 
                        ["groups" => ["pasaje", "rutaPasaje", "usuario"]]
                    );
                        
                    return new Response($pasaje);
                }

                return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
            }

            return new JsonResponse(["msg" => "Usuario no encontrado"], 404);
        }

        return new JsonResponse(["msg" => "Pasaje no encontrado"], 404);
    }
}

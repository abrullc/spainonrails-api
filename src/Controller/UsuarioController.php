<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class UsuarioController extends AbstractController
{
    public function usuarios(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET")) {
            $usuarios = $this->getDoctrine()
                ->getRepository(Usuario::class)
                ->findAll();

            $usuarios = $serializer->serialize(
                $usuarios,
                "json",
                ["groups" => ["usuario"]]
            );

            return new Response($usuarios);
        }

        if ($request->isMethod("POST")) {
            $bodyData = $request->getContent();
            $usuario = $serializer->deserialize(
                $bodyData,
                Usuario::class,
                "json"
            );

            $this->getDoctrine()->getManager()->persist($usuario);
            $this->getDoctrine()->getManager()->flush();

            $usuario = $serializer->serialize(
                $usuario, 
                "json", 
                ["groups" => ["usuario"]]
            );
            
            return new Response($usuario);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function usuario(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $usuario = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findOneBy(["id" => $id]);
        
        if (!empty($usuario))
        {
            if ($request->isMethod("GET")) {
                $usuario = $serializer->serialize(
                    $usuario,
                    "json",
                    ["groups" => ["usuario"]]
                );
    
                return new Response($usuario);
            }
    
            if ($request->isMethod("PUT")) {
                $bodyData = $request->getContent();
                $usuario = $serializer->deserialize(
                    $bodyData,
                    Usuario::class,
                    "json",
                    ["object_to_populate" => $usuario]
                );
                    
                $this->getDoctrine()->getManager()->persist($usuario);
                $this->getDoctrine()->getManager()->flush();
    
                $usuario = $serializer->serialize(
                    $usuario,
                    "json",
                    ["groups" => ["usuario"]]
                );
    
                return new Response($usuario);
            }
    
            if ($request->isMethod("DELETE")) {
                $deletedUsuario = clone $usuario;
                $this->getDoctrine()->getManager()->remove($usuario);
                $this->getDoctrine()->getManager()->flush();
                
                $deletedUsuario = $serializer->serialize(
                    $deletedUsuario, 
                    "json", 
                    ["groups" => ["usuario"]]
                );
    
                return new Response($deletedUsuario);
            }
    
            return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
        }

        return new JsonResponse(["msg" => "Usuario no encontrado"], 404);
    }
}

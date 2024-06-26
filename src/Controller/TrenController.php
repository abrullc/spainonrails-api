<?php

namespace App\Controller;

use App\Entity\Ruta;
use App\Entity\Tren;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TrenController extends AbstractController
{
    public function trenes(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET")) {
            $trenes = $this->getDoctrine()
                ->getRepository(Tren::class)
                ->findAll();

            foreach ($trenes as $tren)
            {
                $imagePath = $tren->getImagen();
                if (!empty($imagePath))
                {
                    if (str_starts_with($imagePath, "/images"))
                    {
                        $tren->setImagen($request->getSchemeAndHttpHost() . $imagePath);
                    }
                }
            }

            $trenes = $serializer->serialize(
                $trenes,
                "json",
                ["groups" => ["tren"]]
            );

            return new Response($trenes);
        }

        if ($request->isMethod("POST")) {
            $bodyData = $request->getContent();
            $tren = $serializer->deserialize(
                $bodyData,
                Tren::class,
                "json"
            );

            $this->getDoctrine()->getManager()->persist($tren);
            $this->getDoctrine()->getManager()->flush();

            $tren = $serializer->serialize(
                $tren, 
                "json", 
                ["groups" => ["tren"]]
            );
            
            return new Response($tren);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function tren(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $tren = $this->getDoctrine()
            ->getRepository(Tren::class)
            ->findOneBy(["id" => $id]);

        if ($request->isMethod("GET")) {
            $imagePath = $tren->getImagen();
            if (!empty($imagePath))
            {
                if (str_starts_with($imagePath, "/images"))
                {
                    $tren->setImagen($request->getSchemeAndHttpHost() . $imagePath);
                }
            }

            $tren = $serializer->serialize(
                $tren,
                "json",
                ["groups" => ["tren"]]
            );

            return new Response($tren);
        }

        if ($request->isMethod("PUT")) {
            if (!empty($tren)) {
                $bodyData = $request->getContent();
                $tren = $serializer->deserialize(
                    $bodyData,
                    Tren::class,
                    "json",
                    ["object_to_populate" => $tren]
                );
                
                $this->getDoctrine()->getManager()->persist($tren);
                $this->getDoctrine()->getManager()->flush();

                $tren = $serializer->serialize(
                    $tren,
                    "json",
                    ["groups" => ["tren"]]
                );

            return new Response($tren);
            }

            return new JsonResponse(["msg" => "Tren no encontrado"], 404);
        }

        if ($request->isMethod("DELETE")) {
            $deletedTren = clone $tren;
            $this->getDoctrine()->getManager()->remove($tren);
            $this->getDoctrine()->getManager()->flush();
            
            $deletedTren = $serializer->serialize(
                $deletedTren, 
                "json", 
                ["groups" => ["tren"]]
            );

            return new Response($deletedTren);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function rutasTren(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $tren = $this->getDoctrine()
            ->getRepository(Tren::class)
            ->findOneBy(["id" => $id]);

        if (!empty($tren))
        {
            if ($request->isMethod("GET"))
            {
                $rutasTren = $this->getDoctrine()
                    ->getRepository(Ruta::class)
                    ->findBy(["tren" => $tren]);

                $rutasTren = $serializer->serialize(
                $rutasTren,
                "json",
                ["groups" => ["rutaTren"]]
            );

            return new Response($rutasTren);
            }

            return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
        }

        return new JsonResponse(["msg" => "Tren no encontrado"], 404);
    }
}

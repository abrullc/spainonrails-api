<?php

namespace App\Controller;

use App\Entity\PlanViaje;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PlanViajeController extends AbstractController
{
    public function planesViaje(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET")) {
            $planesViaje = $this->getDoctrine()
                ->getRepository(PlanViaje::class)
                ->findAll();

            $planesViaje = $serializer->serialize(
                $planesViaje,
                "json",
                ["groups" => ["planViaje"]]
            );

            return new Response($planesViaje);
        }

        if ($request->isMethod("POST")) {
            $bodyData = $request->getContent();
            $planViaje = $serializer->deserialize(
                $bodyData,
                PlanViaje::class,
                "json"
            );

            $this->getDoctrine()->getManager()->persist($planViaje);
            $this->getDoctrine()->getManager()->flush();

            $planViaje = $serializer->serialize(
                $planViaje, 
                "json", 
                ["groups" => ["planViaje"]]
            );
            
            return new Response($planViaje);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }

    public function planViaje(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $planViaje = $this->getDoctrine()
            ->getRepository(PlanViaje::class)
            ->findOneBy(["id" => $id]);

        if ($request->isMethod("GET")) {
            $planViaje = $serializer->serialize(
                $planViaje,
                "json",
                ["groups" => ["planViaje"]]
            );

            return new Response($planViaje);
        }

        if ($request->isMethod("PUT")) {
            if (!empty($planViaje)) {
                $bodyData = $request->getContent();
                $planViaje = $serializer->deserialize(
                    $bodyData,
                    PlanViaje::class,
                    "json",
                    ["object_to_populate" => $planViaje]
                );
                
                $this->getDoctrine()->getManager()->persist($planViaje);
                $this->getDoctrine()->getManager()->flush();

                $planViaje = $serializer->serialize(
                    $planViaje,
                    "json",
                    ["groups" => ["planViaje"]]
                );

            return new Response($planViaje);
            }

            return new JsonResponse(["msg" => "Plan de viaje no encontrado"], 404);
        }

        if ($request->isMethod("DELETE")) {
            $deletedPlanViaje = clone $planViaje;
            $this->getDoctrine()->getManager()->remove($planViaje);
            $this->getDoctrine()->getManager()->flush();
            
            $deletedPlanViaje = $serializer->serialize(
                $deletedPlanViaje, 
                "json", 
                ["groups" => ["planViaje"]]
            );

            return new Response($deletedPlanViaje);
        }

        return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
    }
}

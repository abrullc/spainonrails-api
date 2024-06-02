<?php

namespace App\Controller;

use App\Entity\PlanViaje;
use App\Entity\PuntoInteres;
use App\Entity\Visita;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class PlanViajeController extends AbstractController
{
    public function planesViaje(SerializerInterface $serializer, Request $request)
    {
        if ($request->isMethod("GET"))
        {
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

        if ($request->isMethod("POST"))
        {
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

        if (!empty($planViaje))
        {
            if ($request->isMethod("GET"))
            {
                $planViaje = $serializer->serialize(
                    $planViaje,
                    "json",
                    ["groups" => ["planViaje"]]
                );

                return new Response($planViaje);
            }

            if ($request->isMethod("PUT"))
            {
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

            if ($request->isMethod("DELETE"))
            {
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

        return new JsonResponse(["msg" => "Plan de viaje no encontrado"], 404);
    }

    public function planViajePuntosInteres(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("id");

        $planViaje = $this->getDoctrine()
            ->getRepository(PlanViaje::class)
            ->findOneBy(["id" => $id]);
        
        if (!empty($planViaje))
        {
            if ($request->isMethod("GET"))
            {
                $visitasPlanViaje = $this->getDoctrine()
                    ->getRepository(Visita::class)
                    ->findBy(["planViaje" => $planViaje]);

                $visitasPlanViaje = $serializer->serialize(
                    $visitasPlanViaje,
                    "json",
                    ["groups" => ["visitaPlanViaje", "puntoInteres"]]
                );

                return new Response($visitasPlanViaje);
            }

            return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
        }

        return new JsonResponse(["msg" => "Plan de viaje no encontrado"], 404);
    }

    public function addPuntoInteresPlanViaje(SerializerInterface $serializer, Request $request)
    {
        $id = $request->get("idPlanViaje");

        $planViaje = $this->getDoctrine()
            ->getRepository(PlanViaje::class)
            ->findOneBy(["id" => $id]);
        
        if (!empty($planViaje))
        {
            $id = $request->get("idPuntoInteres");

            $puntoInteres = $this->getDoctrine()
                ->getRepository(PuntoInteres::class)
                ->findOneBy(["id" => $id]);
            
            if (!empty($puntoInteres))
            {
                if ($request->isMethod("POST"))
                {
                    $bodyData = $request->getContent();
                        $visitaPlanViaje = $serializer->deserialize(
                            $bodyData,
                            Visita::class,
                            "json"
                        );
                        
                        $visitaPlanViaje->setPlanViaje($planViaje);
                        $visitaPlanViaje->setPuntoInteres($puntoInteres);
                        
                        $this->getDoctrine()->getManager()->persist($visitaPlanViaje);
                        $this->getDoctrine()->getManager()->flush();

                        $visitaPlanViaje = $serializer->serialize(
                            $visitaPlanViaje,
                            "json",
                            ["groups" => ["visita", "planViaje", "puntoInteres"]]
                        );

                        return new Response($visitaPlanViaje);
                }

                if ($request->isMethod("DELETE"))
                {
                    $visita = $this->getDoctrine()
                        ->getRepository(Visita::class)
                        ->findOneBy(["planViaje" => $planViaje, "puntoInteres" => $puntoInteres]);
                    
                    $deletedVisita = clone $visita;
                    $this->getDoctrine()->getManager()->remove($visita);
                    $this->getDoctrine()->getManager()->flush();
                    
                    $deletedVisita = $serializer->serialize(
                        $deletedVisita, 
                        "json", 
                        ["groups" => ["visitaPlanViaje", "puntoInteres"]]
                    );

                    return new Response($deletedVisita);
                }

                return new JsonResponse(["msg" => $request->getMethod() . " no permitido"]);
            }

            return new JsonResponse(["msg" => "Punto de interés no encontrado"], 404);
        }

        return new JsonResponse(["msg" => "Plan de viaje no encontrado"], 404);
    }
}

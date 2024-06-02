<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Visita
 *
 * @ORM\Table(name="visita")
 * @ORM\Entity
 */
class Visita
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     * 
     * @Groups("visita")
     */
    private $fecha;

    /**
     * @var PlanViaje
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="PlanViaje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="plan_viaje_id", referencedColumnName="id")
     * })
     * 
     * @Groups("visita")
     */
    private $planViaje;

    /**
     * @var PuntoInteres
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="PuntoInteres")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="punto_interes_id", referencedColumnName="id")
     * })
     * 
     * @Groups("visita")
     */
    private $puntoInteres;

    /**
     * Get the value of fecha
     */
    public function getFecha(): \DateTime
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha(\DateTime $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of planViaje
     */
    public function getPlanViaje(): PlanViaje
    {
        return $this->planViaje;
    }

    /**
     * Set the value of planViaje
     */
    public function setPlanViaje(PlanViaje $planViaje): self
    {
        $this->planViaje = $planViaje;

        return $this;
    }

    /**
     * Get the value of puntoInteres
     */
    public function getPuntoInteres(): PuntoInteres
    {
        return $this->puntoInteres;
    }

    /**
     * Set the value of puntoInteres
     */
    public function setPuntoInteres(PuntoInteres $puntoInteres): self
    {
        $this->puntoInteres = $puntoInteres;

        return $this;
    }
}

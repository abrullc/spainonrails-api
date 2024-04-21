<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tren
 *
 * @ORM\Table(name="tren", uniqueConstraints={@ORM\UniqueConstraint(name="nombre", columns={"nombre"})})
 * @ORM\Entity
 */
class Tren
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="capacidad", type="integer", nullable=false)
     */
    private $capacidad;


}

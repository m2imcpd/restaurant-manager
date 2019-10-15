<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HoraireRepository")
 */
class Horaire
{

    const DAY = [
        0 =>'Lundi',
        1 =>'Mardi',
        2 =>'Mercredi',
        3 =>'Jeudi',
        4 =>'Vendredi',
        5 =>'Samedi',
        6 =>'Dimanche',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $day;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $open_hour_at;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $close_hour_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Restaurant", inversedBy="horaires")
     */
    private $restaurant;

    public function __construct()
    {
        $this->restaurant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        $index=0;
        foreach (Horaire::DAY as $d => $j)
        {
            if($j == $this->day)
            {
                $index = $d;
                break;
            }
        }
        return self::DAY[$index];
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpenHourAt(): ?\DateTimeInterface
    {
        return $this->open_hour_at;
    }

    public function setOpenHourAt(?\DateTimeInterface $open_hour_at): self
    {
        $this->open_hour_at = $open_hour_at;

        return $this;
    }

    public function getCloseHourAt(): ?\DateTimeInterface
    {
        return $this->close_hour_at;
    }

    public function setCloseHourAt(?\DateTimeInterface $close_hour_at): self
    {
        $this->close_hour_at = $close_hour_at;

        return $this;
    }

    /**
     * @return Collection|Restaurant[]
     */
    public function getRestaurant(): Collection
    {
        return $this->restaurant;
    }

    public function addRestaurant(Restaurant $restaurant): self
    {
        if (!$this->restaurant->contains($restaurant)) {
            $this->restaurant[] = $restaurant;
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): self
    {
        if ($this->restaurant->contains($restaurant)) {
            $this->restaurant->removeElement($restaurant);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->day;
    }
}

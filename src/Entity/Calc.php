<?php

namespace App\Entity;

use App\Repository\CalcRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

const MIN_NUMBER = 1;
const MAX_NUMBER = 10000000000;

/**
 * @ORM\Entity(repositoryClass=CalcRepository::class)
 */
class Calc
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 10000000000,
     *      notInRangeMessage = "El número debe estar entre {{ min }} y {{ max }}",
     * )
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function guessNumber(): int
    {
        // Cantidad de intentos
        $attemps = 1;

        // Rango inicial
        $tempMin = MIN_NUMBER;
        $tempMax = MAX_NUMBER;

        // Primer intento
        $prevGuess = 0;
        $guess = floor(($tempMax + $tempMin) / 2);

        while ($guess != $this->number) {
            if ($guess < $this->number) {
                $tempMin = $guess;
            } else {
                $tempMax = $guess;
            }

            $prevGuess = $guess;
            $guess = floor(($tempMax + $tempMin) / 2);

            $attemps++;

            // Evita el loop infinito
            if ($prevGuess == $guess) {
                for ($i = $tempMin; $i <= $tempMax; $i++) {
                    $attemps++;

                    if ($i == $this->number) {
                        break;
                    }
                }

                return $attemps;
            }
        }

        return $attemps;
    }
}

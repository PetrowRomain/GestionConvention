<?php

namespace App\Entity;

use App\Repository\RepresentantRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=RepresentantRepository::class)
 */
class Representant
{
	
	
	public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        
		$metadata->addPropertyConstraint('NomR', new Assert\Regex([
		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
		
			
		]));
		$metadata->addPropertyConstraint('PrenomR', new Assert\Regex([
            'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
			
        ]));
		$metadata->addPropertyConstraint('TelR', new Assert\Regex([
			'pattern' => '/(0)[0-9]{9}/',
			
        ]));
		$metadata->addPropertyConstraint('Fonction', new Assert\Regex([
		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
		
			
		]));
		
	}
	
	
	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomR;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PrenomR;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $TelR;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fonction;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="representants")
     * @ORM\JoinColumn(nullable=true)
     */
    private $LienEnt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomR(): ?string
    {
        return $this->NomR;
    }

    public function setNomR(string $NomR): self
    {
        $this->NomR = $NomR;

        return $this;
    }

    public function getPrenomR(): ?string
    {
        return $this->PrenomR;
    }

    public function setPrenomR(string $PrenomR): self
    {
        $this->PrenomR = $PrenomR;

        return $this;
    }

    public function getTelR(): ?string
    {
        return $this->TelR;
    }

    public function setTelR(string $TelR): self
    {
        $this->TelR = $TelR;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(string $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    public function getLienEnt(): ?Entreprise
    {
        return $this->LienEnt;
    }

    public function setLienEnt(?Entreprise $LienEnt = null): self
    {
        $this->LienEnt = $LienEnt;

        return $this;
    }
}

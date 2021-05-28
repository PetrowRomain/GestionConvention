<?php

namespace App\Entity;

use App\Repository\MaitreStageRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=MaitreStageRepository::class)
 */
class MaitreStage
{
	
		public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        
		$metadata->addPropertyConstraint('NomMS', new Assert\Regex([
		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
		
			
		]));
		$metadata->addPropertyConstraint('PrenomMS', new Assert\Regex([
            'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
			
        ]));
		$metadata->addPropertyConstraint('TelMS', new Assert\Regex([
			'pattern' => '/(0)[0-9]{9}/',
			
        ]));
		$metadata->addPropertyConstraint('FonctionMS', new Assert\Regex([
		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
		
			
		]));
		$metadata->addPropertyConstraint('EmailMS', new Assert\Regex([
            'pattern' => '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[(org)|(fr)|(com)]+$/',
			
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
    private $NomMS;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PrenomMS;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $TelMS;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FonctionMS;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EmailMS;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $LienEnt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMS(): ?string
    {
        return $this->NomMS;
    }

    public function setNomMS(string $NomMS): self
    {
        $this->NomMS = $NomMS;

        return $this;
    }

    public function getPrenomMS(): ?string
    {
        return $this->PrenomMS;
    }

    public function setPrenomMS(string $PrenomMS): self
    {
        $this->PrenomMS = $PrenomMS;

        return $this;
    }

    public function getTelMS(): ?string
    {
        return $this->TelMS;
    }

    public function setTelMS(string $TelMS): self
    {
        $this->TelMS = $TelMS;

        return $this;
    }

    public function getFonctionMS(): ?string
    {
        return $this->FonctionMS;
    }

    public function setFonctionMS(string $FonctionMS): self
    {
        $this->FonctionMS = $FonctionMS;

        return $this;
    }

    public function getEmailMS(): ?string
    {
        return $this->EmailMS;
    }

    public function setEmailMS(string $EmailMS): self
    {
        $this->EmailMS = $EmailMS;

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
	public function __toString(){
		return $this->NomMS;
	}
}

<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
	
	public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
	
	$metadata->addPropertyConstraint('NomRueEnt', new Assert\Regex([
		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
	
	]));
	
	$metadata->addPropertyConstraint('NumRueEnt', new Assert\Regex([
		'pattern' => '/[0-9]{1,3}/',
	
	]));
	
	$metadata->addPropertyConstraint('VilleEnt', new Assert\Regex([
		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
	
	]));
	$metadata->addPropertyConstraint('CodePostalEnt', new Assert\Regex([
            'pattern' => '/[0-9]{5}/',
			
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
    private $RaisonEnt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NumRueEnt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomRueEnt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $VilleEnt;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $CodePostalEnt;

    /**
     * @ORM\OneToMany(targetEntity=Representant::class, mappedBy="LienEnt")
	 * @ORM\JoinColumn(nullable=true)
     */
    private $representants;

    public function __construct()
    {
        $this->representants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRaisonEnt(): ?string
    {
        return $this->RaisonEnt;
    }

    public function setRaisonEnt(string $RaisonEnt): self
    {
        $this->RaisonEnt = $RaisonEnt;

        return $this;
    }

    public function getNumRueEnt(): ?string
    {
        return $this->NumRueEnt;
    }

    public function setNumRueEnt(string $NumRueEnt): self
    {
        $this->NumRueEnt = $NumRueEnt;

        return $this;
    }

    public function getNomRueEnt(): ?string
    {
        return $this->NomRueEnt;
    }

    public function setNomRueEnt(string $NomRueEnt): self
    {
        $this->NomRueEnt = $NomRueEnt;

        return $this;
    }

    public function getVilleEnt(): ?string
    {
        return $this->VilleEnt;
    }

    public function setVilleEnt(string $VilleEnt): self
    {
        $this->VilleEnt = $VilleEnt;

        return $this;
    }

    public function getCodePostalEnt(): ?string
    {
        return $this->CodePostalEnt;
    }

    public function setCodePostalEnt(string $CodePostalEnt): self
    {
        $this->CodePostalEnt = $CodePostalEnt;

        return $this;
    }

    /**
     * @return Collection|Representant[]
     */
    public function getRepresentants(): Collection
    {
        return $this->representants;
    }

    public function addRepresentant(Representant $representant): self
    {
        if (!$this->representants->contains($representant)) {
            $this->representants[] = $representant;
            $representant->setLienEnt($this);
        }

        return $this;
    }

    public function removeRepresentant(Representant $representant): self
    {
        if ($this->representants->removeElement($representant)) {
            // set the owning side to null (unless already changed)
            if ($representant->getLienEnt() === $this) {
                $representant->setLienEnt(null);
            }
        }

        return $this;
    }
	public function __toString(){
		return $this->RaisonEnt;
	}
}

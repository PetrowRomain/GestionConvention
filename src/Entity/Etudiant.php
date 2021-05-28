<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;


/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
	
	public static function loadValidatorMetadata(ClassMetadata $metadata)
             {
                 
         		$metadata->addPropertyConstraint('NomE', new Assert\Regex([
         		'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
         		
         			
         		]));
         		$metadata->addPropertyConstraint('PrenomE', new Assert\Regex([
                     'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
         			
                 ]));
         		$metadata->addPropertyConstraint('VilleE', new Assert\Regex([
                     'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
         			
         		]));
         		$metadata->addPropertyConstraint('NumRueE', new Assert\Regex([
                     'pattern' => '/[0-9]{1,3}/',
         			
         			
                 ]));
         		$metadata->addPropertyConstraint('NomRueE', new Assert\Regex([
                     'pattern' => '/^[a-zA-Zéèêëçùï\s.-]+$/',
         			
         		]));
         		$metadata->addPropertyConstraint('CodePostalE', new Assert\Regex([
                     'pattern' => '/[0-9]{5}/',
         			
                 ]));
         		$metadata->addPropertyConstraint('TelE', new Assert\Regex([
         			'pattern' => '/(0)[0-9]{9}/',
         			
                 ]));
         		$metadata->addPropertyConstraint('EmailE', new Assert\Regex([
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
    private $NomE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PrenomE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NumRueE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomRueE;

    /**
     * @ORM\Column(type="string", length=5)
	 * 
     */
    private $CodePostalE;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $TelE;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $EmailE;

    /**
     * @ORM\OneToOne(targetEntity=Stage::class, mappedBy="lienE", cascade={"persist", "remove"})
     */
    private $stage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $VilleE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CompE;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomE(): ?string
    {
        return $this->NomE;
    }

    public function setNomE(string $NomE): self
    {
        $this->NomE = $NomE;

        return $this;
    }

    public function getPrenomE(): ?string
    {
        return $this->PrenomE;
    }

    public function setPrenomE(string $PrenomE): self
    {
        $this->PrenomE = $PrenomE;

        return $this;
    }

    public function getNumRueE(): ?string
    {
        return $this->NumRueE;
    }

    public function setNumRueE(string $NumRueE): self
    {
        $this->NumRueE = $NumRueE;

        return $this;
    }

    public function getNomRueE(): ?string
    {
        return $this->NomRueE;
    }

    public function setNomRueE(string $NomRueE): self
    {
        $this->NomRueE = $NomRueE;

        return $this;
    }

    public function getCodePostalE(): ?string
    {
        return $this->CodePostalE;
    }

    public function setCodePostalE(string $CodePostalE): self
    {
        $this->CodePostalE = $CodePostalE;

        return $this;
    }

    public function getTelE(): ?string
    {
        return $this->TelE;
    }

    public function setTelE(string $TelE): self
    {
        $this->TelE = $TelE;

        return $this;
    }

    public function getEmailE(): ?string
    {
        return $this->EmailE;
    }

    public function setEmailE(string $EmailE): self
    {
        $this->EmailE = $EmailE;

        return $this;
    }

	
	public function __toString(){
         		return $this->NomE;
         		}

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        // unset the owning side of the relation if necessary
        if ($stage === null && $this->stage !== null) {
            $this->stage->setLienE(null);
        }

        // set the owning side of the relation if necessary
        if ($stage !== null && $stage->getLienE() !== $this) {
            $stage->setLienE($this);
        }

        $this->stage = $stage;

        return $this;
    }

    public function getVilleE(): ?string
    {
        return $this->VilleE;
    }

    public function setVilleE(string $VilleE): self
    {
        $this->VilleE = $VilleE;

        return $this;
    }

    public function getCompE(): ?string
    {
        return $this->CompE;
    }

    public function setCompE(?string $CompE): self
    {
        $this->CompE = $CompE;

        return $this;
    }
}

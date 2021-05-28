<?php

namespace App\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Repository\StageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 *@Annotation
 *@Template("@etudiant/{id}/pdf.html.twig")
 */
class Stage
{

	
	
	
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
	* 
	 * @ORM\Column(type="date")
     */
    private $DateD;

    /**
	*
	 * 
     * @ORM\Column(type="date")
     */
    private $DateF;

    /**
	 * 
	 *
     * @ORM\OneToOne(targetEntity=Etudiant::class, inversedBy="stage", cascade={"persist"})
     */
    private $lienE;

    /**
     * @ORM\ManyToOne(targetEntity=MaitreStage::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $LienMS;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateD(): ?\DateTime
    {
        return $this->DateD;
    }

    public function setDateD(\DateTime $DateD): self
    {
        $this->DateD = $DateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->DateF;
    }

    public function setDateF(\DateTimeInterface $DateF): self
    {
        $this->DateF = $DateF;

        return $this;
    }

    public function getLienE(): ?Etudiant
    {
        return $this->lienE;
    }

    public function setLienE(?Etudiant $lienE): self
    {
        $this->lienE = $lienE;

        return $this;
    }

    public function getLienMS(): ?MaitreStage
    {
        return $this->LienMS;
    }

    public function setLienMS(?MaitreStage $LienMS): self
    {
        $this->LienMS = $LienMS;

        return $this;
    }
	public function __toString(){
		return $this->DateD->format('d-m-y')." / ".$this->DateF->format('d-m-y')." / ". $this->LienMS;
	}
}

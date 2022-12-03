<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $DepartmentId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $DepartmentName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Address;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="departmentId",cascade={"persist", "remove"},orphanRemoval=true)
     */
    private $Students;

    public function __construct()
    {
        $this->Students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentId(): ?int
    {
        return $this->DepartmentId;
    }

    public function setDepartmentId(int $DepartmentId): self
    {
        $this->DepartmentId = $DepartmentId;

        return $this;
    }

    public function getDepartmentName(): ?string
    {
        return $this->DepartmentName;
    }

    public function setDepartmentName(string $DepartmentName): self
    {
        $this->DepartmentName = $DepartmentName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): self
    {
        $this->Address = $Address;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->Students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->Students->contains($student)) {
            $this->Students[] = $student;
            $student->setDepartmentId($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->Students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getDepartmentId() === $this) {
                $student->setDepartmentId(null);
            }
        }

        return $this;
    }
}

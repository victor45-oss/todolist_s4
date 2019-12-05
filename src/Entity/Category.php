<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Todo", mappedBy="category_id", orphanRemoval=true)
     */
    private $todos;

    public function __construct()
    {
        $this->todos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Todo[]
     */
    public function getTodos(): Collection
    {
        return $this->todos;
    }

    public function addTodo(Todo $todo): self
    {
        if (!$this->todos->contains($todo)) {
            $this->todos[] = $todo;
            $todo->setCategoryId($this);
        }

        return $this;
    }

    public function removeTodo(Todo $todo): self
    {
        if ($this->todos->contains($todo)) {
            $this->todos->removeElement($todo);
            // set the owning side to null (unless already changed)
            if ($todo->getCategoryId() === $this) {
                $todo->setCategoryId(null);
            }
        }

        return $this;
    }
}

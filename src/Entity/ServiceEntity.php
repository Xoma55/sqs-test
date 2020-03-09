<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ServiceEntity
{
    /**
     * @Assert\Type("Ramsey\Uuid\UuidInterface")
     */
    protected $id;

    /**
     * @Assert\Type("string")
     */
    protected $name;

    /**
     * @Assert\Type(type={"alpha", "digit"})
     */
    protected $alias;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     */
    public function setAlias($alias): void
    {
        $this->alias = $alias;
    }
}

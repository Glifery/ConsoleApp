<?php

namespace AppBundle\Model\Space;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Model\Space\Options\Positionable;
use AppBundle\Model\Space\Options\Stylable;

/**
 * Class Window
 * @package AppBundle\Model\Space
 */
class Window
{
    use Positionable;
    use Stylable;

    /** @var integer */
    private $width;

    /** @var integer */
    private $height;

    /** @var integer */
    private $parent;

    /**
     * @var ArrayCollection|Window[]
     */
    private $children;

    /**
     * @var ArrayCollection|Object[]
     */
    private $objects;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->objects = new ArrayCollection();
    }

    /**
     * @return Window[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Window[]|ArrayCollection $children
     * @return $this
     */
    public function setChildren($children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * @param Window $child
     * @return $this
     */
    public function addChild(Window $child)
    {
        $this->children->add($child);

        return $this;
    }

    /**
     * @return $this
     */
    public function clearChildren()
    {
        $this->children->clear();

        return $this;
    }

    /**
     * @return Object[]|ArrayCollection
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param Object[]|ArrayCollection $objects
     * @return $this
     */
    public function setObjects($objects)
    {
        foreach ($objects as $object) {
            $this->addObject($object);
        }

        return $this;
    }

    /**
     * @param Object $object
     * @return $this
     */
    public function addObject(Object $object)
    {
        $this->objects->add($object);

        return $this;
    }

    /**
     * @return $this
     */
    public function clearObjects()
    {
        $this->objects->clear();

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param int $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}
<?php

namespace AppBundle\Model\Space\Options;

use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;

/**
 * Class Stylable
 * @package AppBundle\Model\Space\Options
 */
trait Stylable
{
    /** @var OutputFormatterStyleInterface */
    private $style;

    /**
     * @param OutputFormatterStyleInterface $parentStyle
     * @return OutputFormatterStyleInterface
     */
    public function getStyleOrParent(OutputFormatterStyleInterface $parentStyle = null)
    {
        if ($style = $this->getStyle()) {
            return $style;
        }

        return $parentStyle;
    }

    /**
     * @return OutputFormatterStyleInterface
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * @param OutputFormatterStyleInterface $style
     * @return $this
     */
    public function setStyle(OutputFormatterStyleInterface $style = null)
    {
        $this->style = $style;

        return $this;
    }
} 
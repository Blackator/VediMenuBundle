<?php

namespace Blackator\Bundle\VediMenuBundle\Component;

class Burger
{
    protected $caption = '';
    protected $title = '';
    protected $classes = '';
    protected $icon = '';
    protected $fontIcon = '';

    /**
     * Get burger caption
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * Set burger caption
     * @param string $caption Caption
     * @return $this
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * Get burger title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set burger title
     * @param string $title Title
     * @return $this;
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get burger classes
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * Set burger classes
     * @param string $classes Classes string
     * @return $this;
     */
    public function setClasses(string $classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Get item icon
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set item icon
     * @param string $icon Icon path
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get item font icon class
     * @return string
     */
    public function getFontIcon(): string
    {
        return $this->fontIcon;
    }

    /**
     * Set item font icon class
     * @param string $fontIcon Font classes
     * @return $this
     */
    public function setFontIcon(string $fontIcon): self
    {
        $this->fontIcon = $fontIcon;
        return $this;
    }
}
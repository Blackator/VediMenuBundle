<?php

namespace Blackator\Bundle\VediMenuBundle\Component;

class CloseButton
{
    protected $caption = '';
    protected $title = '';
    protected $icon = '';
    protected $fontIcon = '';
    protected $classes = '';

    /**
     * Get button caption
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * Set button caption
     * @param string $caption Caption string
     * @return $this
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * Get button title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set button title
     * @param string $title Title string
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get button icon
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * Set button icon
     * @param string $icon Icon path
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get button font icon
     * @return string
     */
    public function getFontIcon(): string
    {
        return $this->fontIcon;
    }

    /**
     * Set button font icon
     * @param string $fontIcon Font icon string
     * @return $this
     */
    public function setFontIcon(string $fontIcon): self
    {
        $this->fontIcon = $fontIcon;
        return $this;
    }

    /**
     * Get button classes
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * Set button classes
     * @param string $classes Classes string
     * @return $this
     */
    public function setClasses(string $classes): self
    {
        $this->classes = $classes;
        return $this;
    }


}
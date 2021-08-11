<?php

namespace Blackator\Bundle\VediMenuBundle\Component;

use Blackator\Bundle\VediMenuBundle\Loaders\MenuLoaderInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class Menu
{
    protected $name;
    protected $template;
    protected $classes = '';
    protected $listClasses = '';
    protected $itemClasses = '';
    protected $linkClasses = '';
    protected $burger;
    protected $closeButton;
    protected $items;

    const DEFAULT_TEMPLATE = '@VediMenu/default.html.twig';

    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->template = self::DEFAULT_TEMPLATE;
        $this->items = new MenuItemsCollection();
    }

    /**
     * Get name of menu
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name of menu
     * @param string $name The name of menu
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get menu template
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Set menu template
     * @param string $template Template path
     * @return $this
     */
    public function setTemplate(string $template): self
    {
        $this->template = empty($template) ? self::DEFAULT_TEMPLATE : $template;
        return $this;
    }

    /**
     * Get menu classes
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * Set menu classes
     * @param string $classes Menu classes string
     * @return $this
     */
    public function setClasses(string $classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Get list classes
     * @return string
     */
    public function getListClasses(): string
    {
        return $this->listClasses;
    }

    /**
     * Set list classes
     * @param string $listClasses Menu list classes string
     * @return $this
     */
    public function setListClasses(string $listClasses): self
    {
        $this->listClasses = $listClasses;
        return $this;
    }

    /**
     * Get item classes
     * @return string
     */
    public function getItemClasses(): string
    {
        return $this->itemClasses;
    }

    /**
     * Set item classes
     * @param string $itemClasses Item classes
     * @return $this
     */
    public function setItemClasses(string $itemClasses): self
    {
        $this->itemClasses = $itemClasses;
        return $this;
    }

    /**
     * Get link classes
     * @return string
     */
    public function getLinkClasses(): string
    {
        return $this->linkClasses;
    }

    /**
     * Set link classes
     * @param string $linkClasses Link classes
     * @return $this
     */
    public function setLinkClasses(string $linkClasses): self
    {
        $this->linkClasses = $linkClasses;
        return $this;
    }

    /**
     * Get menu burger
     * @return null|Burger
     */
    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    /**
     * Set menu burger
     * @param null|Burger $burger Menu burger
     * @return $this
     */
    public function setBurger(?Burger $burger = null): self
    {
        $this->burger = $burger;
        return $this;
    }

    /**
     * Get close button
     * @return CloseButton|null
     */
    public function getCloseButton(): ?CloseButton
    {
        return $this->closeButton;
    }

    /**
     * Set close button
     * @param CloseButton|null $closeButton
     * @return $this
     */
    public function setCloseButton(?CloseButton $closeButton): self
    {
        $this->closeButton = $closeButton;
        return $this;
    }

    /**
     * Get menu items array
     * @return MenuItemsCollection
     */
    public function getItems(): MenuItemsCollection
    {
        return $this->items;
    }

    /**
     * Set menu items array
     * @param MenuItemsCollection $items
     * @return $this
     */
    public function setItems(MenuItemsCollection $items): self
    {
        $this->items = $items;
        return $this;
    }
}
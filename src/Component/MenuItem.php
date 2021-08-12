<?php

namespace Blackator\Bundle\VediMenuBundle\Component;

use Symfony\Component\HttpFoundation\Request;

class MenuItem
{
    protected $name;
    protected $disabled = false;
    protected $index = 0;
    protected $caption = '';
    protected $title = '';
    protected $url = '';
    protected $icon = '';
    protected $fontIcon = '';
    protected $classes = '';
    protected $linkClasses = '';
    protected $items;
    protected $urls = [];
    protected $routes = [];
    protected $roles = [];

    public function __construct(string $name = '')
    {
        $this->name = $name;
        $this->items = new MenuItemsCollection();
    }

    /**
     * Check item activity by request
     * @param Request|null $request Current request
     * @return bool
     */
    public function isActive(?Request $request = null): bool
    {
        if ($request === null) return false;
        $url = trim($this->url, '/');
        $uri = trim($request->getRequestUri(), '/');
        $requestUri = trim($request->getUri(), '/');
        if ($url === $uri || $url === $requestUri) return true;
        if (in_array($uri, $this->urls) || in_array($requestUri, $this->urls)) return true;
        return $request->attributes->has('_route') && in_array($request->attributes->get('_route'), $this->routes);
    }

    /**
     * Get item name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set item name
     * @param string $name Item name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get disabled mode
     * @return bool
     */
    public function getDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Set disabled mode
     * @param bool $disabled Disabled mode state
     * @return $this
     */
    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Get item index
     * @return int
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * Set item index
     * @param int $index Index
     * @return $this
     */
    public function setIndex(int $index): self
    {
        $this->index = $index;
        return $this;
    }

    /**
     * Get item caption
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * Set item caption
     * @param string $caption Caption string
     * @return $this
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * Get item title
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set item title
     * @param string $title Title string
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get item URL
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Sry item URL
     * @param string $url URL string
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
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

    /**
     * Get item classes
     * @return string
     */
    public function getClasses(): string
    {
        return $this->classes;
    }

    /**
     * Set item classes
     * @param string $classes Item classes
     * @return $this
     */
    public function setClasses(string $classes): self
    {
        $this->classes = $classes;
        return $this;
    }

    /**
     * Get item link classes
     * @return string
     */
    public function getLinkClasses(): string
    {
        return $this->linkClasses;
    }

    /**
     * Set item link classes
     * @param string $linkClasses Link classes
     * @return $this
     */
    public function setLinkClasses(string $linkClasses): self
    {
        $this->linkClasses = $linkClasses;
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
     * @param MenuItemsCollection $items Items collection
     * @return $this
     */
    public function setItems(MenuItemsCollection $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * get item urls
     * @return array
     */
    public function getUrls(): array
    {
        return $this->urls;
    }

    /**
     * Set item urls
     * @param array $urls Url array
     * @return $this
     */
    public function setUrls(array $urls): self
    {
        $this->urls = $urls;
        return $this;
    }

    /**
     * Get item routes
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Set item routes
     * @param array $routes Routes array
     * @return $this
     */
    public function setRoutes(array $routes): self
    {
        $this->routes = $routes;
        return $this;
    }

    /**
     * Get item roles
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Set item roles
     * @param array $roles Roles array
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
}
<?php

namespace Blackator\Bundle\VediMenuBundle\MenuGenerator;

use Blackator\Bundle\VediMenuBundle\Component\Burger;
use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Blackator\Bundle\VediMenuBundle\Component\MenuItem;
use Blackator\Bundle\VediMenuBundle\Component\MenuItemsCollection;
use Blackator\Bundle\VediMenuBundle\Loaders\MenuLoaderInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class MenuGenerator
{
    protected $urlGenerator;
    protected $translator;
    protected $translatorDomain = 'messages';

    public function __construct(UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

    /**
     * Get URL generator
     * @return UrlGeneratorInterface
     */
    public function getUrlGenerator(): UrlGeneratorInterface
    {
        return $this->urlGenerator;
    }

    /**
     * Set URL generator
     * @param UrlGeneratorInterface $urlGenerator URL generator
     * @return $this
     */
    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator): self
    {
        $this->urlGenerator = $urlGenerator;
        return $this;
    }

    /**
     * Get translator
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * Set translator
     * @param TranslatorInterface $translator
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * get translator domain
     * @return string
     */
    public function getTranslatorDomain(): string
    {
        return $this->translatorDomain;
    }

    /**
     * Set translator domain
     * @param string $translatorDomain
     * @return $this
     */
    public function setTranslatorDomain(string $translatorDomain = 'messages'): self
    {
        $this->translatorDomain = $translatorDomain;
        return $this;
    }

    /**
     * Create menu
     * @param MenuLoaderInterface|null $loader Menu loader
     * @return Menu
     */
    public function create(string $name, MenuLoaderInterface $loader): Menu
    {
        $data = $loader->load();
        if (!empty($data[$name])) return $this->build($data[$name]);
        return $this->build($name, $data);
    }

    /**
     * Build menu data from loaded array
     * @param array $data Loaded array
     * @return Menu
     */
    protected function build(string $name, array $data): Menu
    {
        $menu = new Menu($name);
        if (isset($data['template'])) $menu->setTemplate($data['template']);
        $menu->setClasses(isset($data['classes']) ? $data['classes'] : '');
        $menu->setListClasses(isset($data['list_classes']) ? $data['list_classes'] : '');
        $menu->setItemClasses(isset($data['item_classes']) ? $data['item_classes'] : '');
        $menu->setLinkClasses(isset($data['link_classes']) ? $data['link_classes'] : '');
        $this->translatorDomain = isset($data['translation_domain']) ? $data['translation_domain'] : '';
        $menu->setBurger($this->buildBurger($data));
        $menu->setItems($this->buildItems($data));
        return $menu;
    }

    /**
     * Build burger from array
     * @param array $burgerData Burger array
     * @return Burger|null
     */
    protected function buildBurger(array $data): ?Burger
    {
        if (!isset($data['burger'])) return null;
        $burger = new Burger();
        if (isset($data['burger']['caption'])) $burger->setCaption($data['burger']['caption']);
        if (isset($data['burger']['title'])) $burger->setCaption($data['burger']['title']);
        if (isset($data['burger']['classes'])) $burger->setCaption($data['burger']['classes']);
        if (isset($data['burger']['icon'])) $burger->setCaption($data['burger']['icon']);
        if (isset($data['burger']['font_icon'])) $burger->setCaption($data['burger']['font_icon']);
        return $burger;
    }

    /**
     * Build items tree from array
     * @param array $itemsData Items array
     * @return MenuItemsCollection
     */
    protected function buildItems(array $data): MenuItemsCollection
    {
        $collection = new MenuItemsCollection();
        if (isset($data['items'])) {
            foreach ($data['items'] as $name => $itemData) {
                $item = new MenuItem($name);

                if (!empty($itemData['url'])) {
                    $item->setUrl($itemData['url']);
                } else {
                    if (!empty($itemData['route'])) {
                        if ($this->urlGenerator) {
                            $urlParams = !empty($itemData['route_params']) ? $itemData['route_params'] : [];
                            try {
                                $item->setUrl($this->urlGenerator->generate($itemData['route'], $urlParams));
                            } catch (RouteNotFoundException $e) {
                                $item->setUrl('');
                            }
                        } else {
                            $item->setUrl($itemData['route']);
                        }
                    }
                }
                if (isset($itemData['index'])) $item->setIndex($itemData['index']);
                if (isset($itemData['caption'])) $item->setCaption($itemData['caption']);
                if (isset($itemData['title'])) $item->setTitle($itemData['title']);
                if (isset($itemData['roles'])) $item->setRoles($itemData['roles']);
                if (isset($itemData['classes'])) $item->setClasses($itemData['classes']);
                if (isset($itemData['link_classes'])) $item->setLinkClasses($itemData['link_classes']);
                if (isset($itemData['icon'])) $item->setIcon($itemData['icon']);
                if (isset($itemData['font_icon'])) $item->setFontIcon($itemData['font_icon']);
                if (isset($itemData['routes'])) $item->setRoutes($itemData['routes']);
                if (isset($itemData['urls'])) $item->setUrls($itemData['urls']);
                $item->setItems($this->buildItems($itemData));
                $collection[] = $item;
            }
        }
        return $collection;
    }
}
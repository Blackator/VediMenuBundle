<?php

namespace Blackator\Bundle\VediMenuBundle\Loaders;

use Blackator\Bundle\VediMenuBundle\Component\Burger;
use Blackator\Bundle\VediMenuBundle\Component\CloseButton;
use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Blackator\Bundle\VediMenuBundle\Component\MenuItem;
use Blackator\Bundle\VediMenuBundle\Component\MenuItemsCollection;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Yaml\Yaml;

class YamlMenuLoader extends AbstractMenuLoader
{
    /**
     * Create Menu from YAML-file
     * @param string $name Name of menu
     * @return Menu
     */
    public function create(string $name, string $filename): Menu
    {
        if (!file_exists($filename)) throw new FileNotFoundException();
        $data = Yaml::parseFile($filename);
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
        $menu->setCloseButton($this->buildCloseButton($data));
        $menu->setItems($this->buildItems($data));
        return $menu;
    }

    /**
     * Build burger from array
     * @param array $data Loaded array
     * @return Burger|null
     */
    protected function buildBurger(array $data): ?Burger
    {
        if (!isset($data['burger'])) return null;
        $burger = new Burger();
        if (!empty($data['burger']['caption'])) $burger->setCaption($this->translator->trans($data['burger']['caption'], [], $this->translatorDomain));
        if (!empty($data['burger']['title'])) $burger->setTitle($this->translator->trans($data['burger']['title'], [], $this->translatorDomain));
        if (isset($data['burger']['classes'])) $burger->setClasses($data['burger']['classes']);
        if (isset($data['burger']['icon'])) $burger->setIcon($data['burger']['icon']);
        if (isset($data['burger']['font_icon'])) $burger->setFontIcon($data['burger']['font_icon']);
        return $burger;
    }

    /**
     * Build close button from array
     * @param array $data Loaded array
     * @return CloseButton|null
     */
    protected function buildCloseButton(array $data): ?CloseButton
    {
        if (!isset($data['close_button'])) return null;
        $close_button = new CloseButton();
        if (!empty($data['close_button']['caption'])) $close_button->setCaption($this->translator->trans($data['close_button']['caption'], [], $this->translatorDomain));
        if (!empty($data['close_button']['title'])) $close_button->setTitle($this->translator->trans($data['close_button']['title'], [], $this->translatorDomain));
        if (isset($data['close_button']['classes'])) $close_button->setClasses($data['close_button']['classes']);
        if (isset($data['close_button']['icon'])) $close_button->setIcon($data['close_button']['icon']);
        if (isset($data['close_button']['font_icon'])) $close_button->setFontIcon($data['close_button']['font_icon']);
        return $close_button;
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
                if (!empty($itemData['caption'])) $item->setCaption($this->translator->trans($itemData['caption'], [], $this->translatorDomain));
                if (isset($itemData['title'])) $item->setTitle($this->translator->trans($itemData['title'], [], $this->translatorDomain));
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
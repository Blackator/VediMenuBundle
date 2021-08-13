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
    protected $file = '';

    public function __construct(string $file)
    {
        $this->setFilename($file);
    }

    /**
     * Get file path
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Set file path
     * @param string $file File path
     * @return $this
     */
    public function setFilename(string $file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Create Menu from YAML-file
     * @param string $name Name of menu
     * @return Menu
     */
    public function load(string $name): Menu
    {
        if (!file_exists($this->file)) throw new FileNotFoundException();
        $data = Yaml::parseFile($this->file);
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
        if (!empty($data['roles'])) {
            if (is_array($data['roles'])) {
                $menu->setRoles($data['roles']);
            } else {
                $menu->setRoles(preg_split("/[\s,]+/", (string)$data['roles'], 0, PREG_SPLIT_NO_EMPTY));
            }
        }
        $menu->setClasses(isset($data['classes']) ? $data['classes'] : '');
        $menu->setListClasses(isset($data['list_classes']) ? $data['list_classes'] : '');
        $menu->setItemClasses(isset($data['item_classes']) ? $data['item_classes'] : '');
        $menu->setLinkClasses(isset($data['link_classes']) ? $data['link_classes'] : '');
        $this->translatorDomain = isset($data['translation_domain']) ? $data['translation_domain'] : '';
        $menu->setBurger($this->buildBurger($data));
        $menu->setCloseButton($this->buildCloseButton($data));
        if ($this->checkRoles($menu->getRoles())) $menu->setItems($this->buildItems($data));
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
        if (!empty($data['burger']['caption'])) $burger->setCaption($this->trans($data['burger']['caption'], [], $this->translatorDomain));
        if (!empty($data['burger']['title'])) $burger->setTitle($this->trans($data['burger']['title'], [], $this->translatorDomain));
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
        if (!empty($data['close_button']['caption'])) $close_button->setCaption($this->trans($data['close_button']['caption'], [], $this->translatorDomain));
        if (!empty($data['close_button']['title'])) $close_button->setTitle($this->trans($data['close_button']['title'], [], $this->translatorDomain));
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
                if (isset($itemData['disabled'])) $item->setDisabled((bool)$itemData['disabled']);
                if (isset($itemData['index'])) $item->setIndex($itemData['index']);
                if (!empty($itemData['caption'])) $item->setCaption($this->trans($itemData['caption'], [], $this->translatorDomain));
                if (isset($itemData['title'])) $item->setTitle($this->trans($itemData['title'], [], $this->translatorDomain));
                if (isset($itemData['roles'])) {
                    if (is_array($itemData['roles'])) {
                        $item->setRoles($itemData['roles']);
                    } else {
                        $item->setRoles(preg_split("/[\s,]+/", (string)$itemData['roles'], 0, PREG_SPLIT_NO_EMPTY));
                    }
                }
                if (isset($itemData['classes'])) $item->setClasses($itemData['classes']);
                if (isset($itemData['link_classes'])) $item->setLinkClasses($itemData['link_classes']);
                if (isset($itemData['icon'])) $item->setIcon($itemData['icon']);
                if (isset($itemData['font_icon'])) $item->setFontIcon($itemData['font_icon']);
                if (isset($itemData['routes'])) $item->setRoutes($itemData['routes']);
                if (isset($itemData['urls'])) $item->setUrls($itemData['urls']);
                $item->setItems($this->buildItems($itemData));
                if ($this->checkRoles($item->getRoles()) && !$item->getDisabled()) $collection[] = $item;
            }
        }
        return $collection;
    }
}
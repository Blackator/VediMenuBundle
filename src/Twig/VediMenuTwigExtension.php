<?php

namespace Blackator\Bundle\VediMenuBundle\Twig;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Blackator\Bundle\VediMenuBundle\MenuGenerator\MenuGenerator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VediMenuTwigExtension extends AbstractExtension
{
    private $menuGenerator;

    public function __construct(MenuGenerator $menuGenerator)
    {
        $this->menuGenerator = $menuGenerator;
    }

    public function getFunctions()
    {
        $function_render_menu = function (Menu $menu, array $params = []) {
            return $this->renderMenu($menu, $params);
        };

        return [
            new TwigFunction('render_menu', $function_render_menu, ['is_safe' => array('html')]),
        ];
    }

    public function renderMenu(Menu $menu, array $params = []): string
    {
        return $this->menuGenerator->render($menu, $params);
    }
}
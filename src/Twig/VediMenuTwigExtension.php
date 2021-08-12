<?php

namespace Blackator\Bundle\VediMenuBundle\Twig;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class VediMenuTwigExtension extends AbstractExtension
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
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
        $params['menu'] = $menu;
        return $this->twig->render($menu->getTemplate(), $params);
    }
}
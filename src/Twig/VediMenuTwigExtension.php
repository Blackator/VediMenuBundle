<?php

namespace Blackator\Bundle\VediMenuBundle\Twig;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * This class contains TWIG extensions to improve the usability of menus.
 */
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

    /**
     * Rendering the menu according to the specified template.
     * @param Menu $menu Rendering menu
     * @param array $params Rendering options
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function renderMenu(Menu $menu, array $params = []): string
    {
        $params['menu'] = $menu;
        return $this->twig->render($menu->getTemplate(), $params);
    }
}
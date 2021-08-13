<?php

namespace Blackator\Bundle\VediMenuBundle\Service;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Blackator\Bundle\VediMenuBundle\Loaders\AbstractMenuLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * This class is a service for conveniently generating Menu objects.
 */
class VediMenu
{
    protected $urlGenerator;
    protected $translator;
    protected $twig;
    protected $security;
    protected $nameIndex = 1;

    public function __construct(UrlGeneratorInterface $urlGenerator, Environment $twig, Security $security, ?TranslatorInterface $translator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
        $this->translator = $translator;
        $this->security = $security;
    }

    /**
     * Preparing the loader and building the Menu.
     * @param AbstractMenuLoader $menuLoader Menu loader
     * @param string $name The name of the menu to use in the template when rendering.
     * @return Menu
     */
    public function create(AbstractMenuLoader $menuLoader, string $name = ''): Menu
    {
        $menuLoader->setServices($this->urlGenerator, $this->twig, $this->security, $this->translator);
        $menuName = !empty($name) ? $name : 'vedi_menu_' . $this->nameIndex++;
        return $menuLoader->load($menuName);
    }
}
<?php

namespace Blackator\Bundle\VediMenuBundle\Service;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Blackator\Bundle\VediMenuBundle\Loaders\AbstractMenuLoader;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class VediMenu
{
    protected $urlGenerator;
    protected $translator;
    protected $twig;
    protected $security;
    protected $nameIndex = 1;

    public function __construct(UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator, Environment $twig, Security $security)
    {
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
        $this->twig = $twig;
        $this->security = $security;
    }

    public function create(AbstractMenuLoader $menuLoader, string $name = ''): Menu
    {
        $menuLoader->setServices($this->urlGenerator, $this->translator, $this->twig, $this->security);
        $menuName = !empty($name) ? $name : 'vedi_menu_' . $this->nameIndex++;
        return $menuLoader->load($menuName);
    }
}
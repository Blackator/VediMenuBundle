<?php

namespace Blackator\Bundle\VediMenuBundle\Loaders;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

abstract class AbstractMenuLoader
{
    protected $urlGenerator;
    protected $translator;
    protected $twig;
    protected $translatorDomain = 'messages';

    public function __construct(UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator, Environment $twig)
    {
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
        $this->twig = $twig;
    }
}
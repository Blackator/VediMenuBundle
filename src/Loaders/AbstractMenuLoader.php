<?php

namespace Blackator\Bundle\VediMenuBundle\Loaders;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Blackator\Bundle\VediMenuBundle\Component\MenuItem;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

abstract class AbstractMenuLoader
{
    protected $urlGenerator;
    protected $translator;
    protected $twig;
    protected $security;
    protected $translatorDomain = 'messages';

    public function setServices(UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator, Environment $twig, Security $security): self
    {
        $this->setUrlGenerator($urlGenerator);
        $this->setTranslator($translator);
        $this->setTwig($twig);
        $this->setSecurity($security);
        return $this;
    }

    public function getUrlGenerator(): ?UrlGeneratorInterface
    {
        return $this->urlGenerator;
    }

    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator): self
    {
        $this->urlGenerator = $urlGenerator;
        return $this;
    }

    public function getTranslator(): ?TranslatorInterface
    {
        return $this->translator;
    }

    public function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;
        return $this;
    }

    public function getTwig(): ?Environment
    {
        return $this->twig;
    }

    public function setTwig(Environment $twig): self
    {
        $this->twig = $twig;
        return $this;
    }

    public function getSecurity(): ?Security
    {
        return $this->security;
    }

    public function setSecurity(Security $security): self
    {
        $this->security = $security;
        return $this;
    }

    public function getTranslatorDomain(): string
    {
        return $this->translatorDomain;
    }

    public function setTranslatorDomain(string $translatorDomain): self
    {
        $this->translatorDomain = $translatorDomain;
        return $this;
    }

    protected function checkRoles(MenuItem $item): bool
    {
        if (empty($item->getRoles())) return true;
        foreach ($item->getRoles() as $role) {
            if ($this->security->isGranted($role)) return true;
        }
        return false;
    }

    abstract public function load(string $name): Menu;
}
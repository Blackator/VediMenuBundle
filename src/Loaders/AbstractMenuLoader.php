<?php

namespace Blackator\Bundle\VediMenuBundle\Loaders;

use Blackator\Bundle\VediMenuBundle\Component\Menu;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

/**
 * This class provides a framework for creating custom menu loaders.
 */
abstract class AbstractMenuLoader
{
    protected $urlGenerator;
    protected $translator;
    protected $twig;
    protected $security;
    protected $translatorDomain = 'messages';

    /**
     * Connecting services required for menu generation.
     * @param UrlGeneratorInterface $urlGenerator URL generator
     * @param Environment $twig TWIG
     * @param Security $security Security
     * @return $this
     */
    public function setServices(UrlGeneratorInterface $urlGenerator, Environment $twig, Security $security, ?TranslatorInterface $translator): self
    {
        $this->urlGenerator = $urlGenerator;
        $this->twig = $twig;
        $this->security = $security;
        $this->translator = $translator;
        return $this;
    }

    protected function trans(string $source, array $params = [], string $domain = 'messages'): string
    {
        if ($this->translator !== null) return $this->translator->trans($source, $params, $domain);
        return $source;
    }

    /**
     * Get security
     * @return Security|null
     */
    public function getSecurity(): ?Security
    {
        return $this->security;
    }

    /**
     * Set security
     * @param Security $security Security service
     * @return $this
     */
    public function setSecurity(Security $security): self
    {
        $this->security = $security;
        return $this;
    }

    /**
     * Get translation domain
     * @return string
     */
    public function getTranslatorDomain(): string
    {
        return $this->translatorDomain;
    }

    /**
     * Set translaton domain
     * @param string $translatorDomain Domain name
     * @return $this
     */
    public function setTranslatorDomain(string $translatorDomain): self
    {
        $this->translatorDomain = $translatorDomain;
        return $this;
    }

    /**
     * Check the availability of roles according to the list.
     * @param array $roles Roles list
     * @return bool
     */
    protected function checkRoles(array $roles): bool
    {
        if (empty($roles)) return true;
        foreach ($roles as $role) {
            if ($this->security->isGranted($role)) return true;
        }
        return false;
    }

    /**
     * Loading data from a source and building a Menu.
     * @param string $name Name of menu
     * @return Menu
     */
    abstract public function load(string $name): Menu;
}
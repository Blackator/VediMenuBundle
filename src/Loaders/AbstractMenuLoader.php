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
     * @param TranslatorInterface $translator Translator
     * @param Environment $twig TWIG
     * @param Security $security Security
     * @return $this
     */
    public function setServices(UrlGeneratorInterface $urlGenerator, Environment $twig, Security $security, $translator = null): self
    {
        $this->setUrlGenerator($urlGenerator);
        $this->setTwig($twig);
        $this->setSecurity($security);
        $this->translator = $translator;
        if ($translator === null || in_array('Symfony\Contracts\Translation\TranslatorInterface', class_implements($translator))) $this->translator = $translator;
        return $this;
    }

    protected function trans(string $source, array $params = [], string $domain = 'messages'): string
    {
        if ($this->translator !== null) return $this->translator->trans($source, $params, $domain);
        return $source;
    }

    /**
     * Get URL generator
     * @return UrlGeneratorInterface|null
     */
    public function getUrlGenerator(): ?UrlGeneratorInterface
    {
        return $this->urlGenerator;
    }

    /**
     * Set URL generator
     * @param UrlGeneratorInterface $urlGenerator URL generator service
     * @return $this
     */
    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator): self
    {
        $this->urlGenerator = $urlGenerator;
        return $this;
    }

    /**
     * Get TWIG
     * @return Environment|null
     */
    public function getTwig(): ?Environment
    {
        return $this->twig;
    }

    /**
     * Set TWIG
     * @param Environment $twig TWIG Environment
     * @return $this
     */
    public function setTwig(Environment $twig): self
    {
        $this->twig = $twig;
        return $this;
    }

    /**
     * Get translator
     * @return TranslatorInterface|null
     */
    public function getTranslator(): ?TranslatorInterface
    {
        return $this->translator;
    }

    /**
     * Set translator
     * @param TranslatorInterface $translator Translator service
     * @return $this
     */
    public function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;
        return $this;
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
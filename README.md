VediMenu bundle for Symfony Flex
===========================

This bundle adds functionality for working with menus in Symfony.

Installation
------------

```bash
composer require blackator/vedi-menu-bundle
```

Usage
-----

```php
<?php

namespace App\Controller;

use Blackator\Bundle\VediMenuBundle\Loaders\YamlMenuLoader;
use Blackator\Bundle\VediMenuBundle\Service\VediMenu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VediMenu $vediMenu): Response
    {
        $menu = $vediMenu->create(new YamlMenuLoader($this->getParameter('kernel.project_dir') . '/config/menu/main_menu.yaml'), 'main');
        return $this->render('home/index.html.twig', ['menu' => $menu]);
    }
}
```
In twig template
```twig
{{ render_menu(menu) }}
```

**VediMenu** - a service for creating a Menu object from loader's data

**YamlMenuLoader** - a class for loading data from YAML file. Extended `Blackator\Bundle\VediMenuBundle\Loaders\AbstractMenuLoader`.

The default TWIG template is located at `vendor/blackator/vedi-menu-bundle/Resources/views/default.html.twig` or `@VediMenu/default.html.twig` as TWIG path.
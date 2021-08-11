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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(YamlMenuLoader $menuLoader): Response
    {
        $menuLoader->setFilename('/home/blackator/www/bundles/BundlesTest/config/menu/main_menu.yaml');
        $menu = $menuLoader->load('main');
        return $this->render('home/index.html.twig', ['menu' => $menu]);
    }
}
```
In twig template
```twig
{{ render_menu(menu) }}
```

**YamlMenuLoader** - a class for creating a Menu object from YAML file data.

The default TWIG template is located at vendor/blackator/Resources/views/default.html.twig.
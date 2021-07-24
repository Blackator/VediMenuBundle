<?php

namespace Blackator\Bundle\VediMenuBundle\Loaders;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Yaml\Yaml;

class YamlLoader implements MenuLoaderInterface
{
    protected $filename;

    public function __construct(string $filename = '')
    {
        $this->filename = $filename;
    }

    /**
     * Get filename
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Set filename
     * @param string $filename Filename
     * @return $this
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function load(string $section = null): ?array
    {
        if (!file_exists($this->filename)) throw new FileNotFoundException();
        $data = Yaml::parseFile($this->filename);
        if ($section !== null) {
            if (isset($data[$section])) return $data[$section];
            return [];
        }
        return $data;
    }

}
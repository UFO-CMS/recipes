<?php

namespace UfoTech\Recipes;

class VersionTags
{
    protected array $versions = [];
    public function __construct(array $tags)
    {
        $versions = [];
        foreach ($tags as $tag) {
            $semVer = explode('.', $tag['name']);
            if (count($semVer) < 3) {
                continue;
            }
            $versions[] = $semVer[0] . '.' . $semVer[1];
        }
        $this->versions = array_unique($versions);
    }

    /**
     * @return array
     */
    public function getVersions(): array
    {
        return $this->versions;
    }
}

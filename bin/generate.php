<?php

use UfoTech\Recipes\JsonDumper;
use UfoTech\Recipes\TagRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$repo = new TagRepository();
$bundles = require_once __DIR__ . '/../configs/bundles.php';
$dumper = new JsonDumper();
foreach ($bundles as $bundle) {
    $repo->addBundleRepositories($bundle);
}
$versions = $repo->parse();

$dumper->dumpJson('index.json', [
    'recipes' => $versions,
    'branch' => "main",
    'is_contrib' => true,
    '_links' => [
        "repository" => "github.com/UFO-Tech/recipes",
        "origin_template" => "{package}:{version}@github.com/UFO-Tech/recipes:main",
        "recipe_template" => "https://api.github.com/repos/UFO-Tech/recipes/contents/{package_dotted}.{version}.json",
    ],
]);

foreach ($bundles as $bundle) {
    foreach ($versions[$bundle] as $version) {
        $dotBundle = str_replace('/', '.', $bundle);
        $dumper->copy(
            __DIR__ . '/../configs/' . $dotBundle . '.json',
            $dotBundle . '.' . $version . '.json'
        );
    }

}



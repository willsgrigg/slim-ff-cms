<?php declare(strict_types=1);

namespace App\Blueprint;

use Symfony\Component\Yaml\Yaml;

class BlueprintRepository
{
    const BLUEPRINTS_PATH = __DIR__ . '/../../user/blueprints/';

    public static function create($blueprintName, $key = null)
    {
        if($key) {
            return file_put_contents(self::BLUEPRINTS_PATH . "$blueprintName.yaml", Yaml::dump($key));
        }

        return file_put_contents(self::BLUEPRINTS_PATH . "$blueprintName.yaml", []);
    }

    public static function update($blueprintName, $key)
    {
        $blueprint = Yaml::parse(file_get_contents(self::BLUEPRINTS_PATH . "$blueprintName.yaml"));

        $blueprint = array_replace_recursive($blueprint, $key);

        return file_put_contents(self::BLUEPRINTS_PATH . "$blueprintName.yaml", Yaml::dump($blueprint));
    }

    public static function get($blueprint)
    {
        return Yaml::parse(file_get_contents(self::BLUEPRINTS_PATH . "$blueprint.yaml"));
    }

    public static function all(): array
    {
        $blueprints = [];

        foreach(glob(self::BLUEPRINTS_PATH . '*.yaml') as $blueprint) {
            $lastSlashPosition = strrpos($blueprint, '/');

            $blueprint = substr($blueprint, $lastSlashPosition + 1);

            $blueprints[] = $blueprint;
        }

        return $blueprints;
    }
}
<?php declare(strict_types=1);

namespace App\Blueprint;

use App\Services\HelperService;
use Symfony\Component\Yaml\Yaml;

class Blueprint
{
    const BLUEPRINTS_PATH = __DIR__ . '/../../user/blueprints/';

    private $blueprint;

    public function __construct(string $slug = null)
    {
        if($slug)
        {
            $this->blueprint = BlueprintRepository::get($slug);

            $this->setSlug($slug);
        }
    }

    ////////////////////////////////////////////////////////////
    ///////////////////////// GETTERS //////////////////////////
    ////////////////////////////////////////////////////////////

    public function getSlug(): string
    {
        return $this->blueprint['slug'];
    }

    public function getFields()
    {
        return $this->blueprint['fields'];
    }

    public function getField(string $field)
    {
        $field = HelperService::makeSlug($field);

        if(!isset($this->blueprint['fields'][$field]))
        {
            return null;
        }

        return $this->blueprint['fields'][$field];
    }

    ////////////////////////////////////////////////////////////
    ///////////////////////// SETTERS //////////////////////////
    ////////////////////////////////////////////////////////////

    public function setSlug(string $slug): void
    {
        $this->blueprint['slug'] = HelperService::makeSlug($slug);
    }

    public function setFields(array $array): void
    {
        $this->blueprint['fields'] = $array;
    }

    public function setField(string $field, string $key, string $attribute): void
    {
        $field = HelperService::makeSlug($field);

        $this->blueprint['fields'][$field][$key] = $attribute;
    }

    public function deleteField(string $field): void
    {
        $field = HelperService::makeSlug($field);

        unset($this->blueprint['fields'][$field]);
    }

    public function save()
    {
        $slug = $this->getSlug();

        return file_put_contents(self::BLUEPRINTS_PATH . "$slug.yaml", Yaml::dump($this->blueprint));
    }
}
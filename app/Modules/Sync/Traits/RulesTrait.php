<?php

namespace App\Modules\Sync\Traits;

use App\Modules\Sync\Converter;

trait RulesTrait
{
    private $rules;

    public function getRules() : array
    {
        $converter = new Converter;

        if (!$this->rules) {
            $this->rules = $converter->getPreparedRules(static::RULES);
        }

        return $this->rules;
    }

    public function getClassName() : string
    {
        return static::CLASS_NAME;
    }

}

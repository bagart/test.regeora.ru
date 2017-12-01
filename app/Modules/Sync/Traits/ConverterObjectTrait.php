<?php

namespace App\Modules\Sync\Traits;

use App\Modules\Sync\Converter;
use App\Modules\Sync\Exceptions\SyncLogicException;
use Illuminate\Database\Eloquent\Model;

trait ConverterObjectTrait
{
    private $rules;

    public function getObject(array $prop) : Model
    {
        $converter = new Converter;
        $prop = $converter->getConvertedProp(
            $prop,
            $this->getRules()
        );
        if (property_exists($this, 'DO_NOT_STRIP')) {
            $prop = $converter->getStripedProp(
                $prop,
                $this->getRules()
            );
        }

        return $this->getPreparedObject($prop);
    }
    public function getPreparedObject($prop) : Model
    {
        $object = null;

        $class = static::CLASS_NAME;

        /**
         * @var Model $model
         */
        $model = new $class;

        foreach (static::EXT_PRIMARY as $key) {

            $model = $model->where($key, $prop[$key]);
        }

        $model = $model->get();
        if ($model->count() > 1) {
            throw new SyncLogicException('duplicate by EXT_PRIMARY:' . get_class($this));
        } elseif ($model->count()) {
            $object = $model->first();
        } else {
            $object = new $class;
        }
        $object->fill($prop);

        return $object;
    }

}

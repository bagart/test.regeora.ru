<?php

namespace App\Modules\Sync;

use App\Modules\Sync\Exceptions\SyncLogicException;
use App\Modules\Sync\Exceptions\SyncValidationException;

class Converter
{
    /**
     * @param array $prop
     * @param array $rules ALLOWED: convert_method, prop, default, required, filter, replace
     * @return array
     * @throws SyncLogicException
     * @throws SyncValidationException
     */
    public function getConvertedProp(array $prop, array $rules) : array
    {
        foreach ($rules as $import_prop => $object_prop) {
            if (!empty($object_prop['replace'])) {
                if (is_callable($object_prop['replace'])) {
                    $prop[$import_prop] = $object_prop['replace']($prop);
                } elseif (
                    is_array($object_prop['replace'])
                    && count($object_prop) == 2
                    && method_exists($object_prop['replace'][0], $object_prop['replace'][1])
                ) {
                    $class = $object_prop['replace'][0];
                    $method = $object_prop['replace'][1];
                    $prop[$import_prop] = $class::$method($prop);
                } else {
                    $prop[$import_prop] = $object_prop['replace'];
                }

                continue;
            }

            if (!isset($prop[$import_prop])) {
                if (isset($object_prop['default'])) {
                    $prop[$import_prop] = $object_prop['default'];
                } elseif (!empty($object_prop['required'])) {
                    throw new SyncValidationException('prop is required');
                }
            } else {
                if (!empty($object_prop['convert_method'])) {
                    $method = $object_prop['convert_method'];
                    $prop[$import_prop] = $this->$method($prop[$import_prop]);
                }

                if (!empty($object_prop['filter'])) {
                    $filter_need = !$prop[$import_prop];
                    if (is_callable($object_prop['filter'])) {
                        $filter_need = !$object_prop['filter']($prop[$import_prop]);
                    }
                    if ($filter_need) {
                        unset($prop[$import_prop]);
                    }
                }

                if ($object_prop['prop'] != $import_prop) {
                    $prop[$object_prop['prop']] = $prop[$import_prop];
                    unset($prop[$import_prop]);
                }
            }
        }

        return $prop;
    }

    public function getStripedProp(array $prop, array $rules) : array
    {
        return array_intersect_key(
            $prop,
            array_column($rules, 'prop')
        );
    }

    public function getPreparedRules(array $rules) : array
    {
        $rules_new = [];
        foreach ($rules as $import_prop => $object_prop) {

            if (is_string($object_prop)) {
                $object_prop = [
                    'prop' => $object_prop,
                ];
            }
            if (empty($object_prop['prop'])) {
                $object_prop['prop'] = $import_prop;
                if (is_numeric($import_prop)) {
                    throw new SyncLogicException('getPreparedRules: !prop and !key');
                }
            } elseif (is_numeric($import_prop)) {
                $import_prop = $object_prop['prop'];
            }
            $rules_new[$import_prop] = $object_prop;
        }

        return $rules_new;
    }

    /**
     * Convert time to minute
     * @example "1:01" => 61
     * @example "00:01" => 1
     * @param string $time
     * @return int
     * @throws SyncValidationException
     */
    public function convertTimeToMinute(string $time): int
    {
        if (!preg_match('~^0?(\d+):0?(\d+)$~', $time, $m)) {
            throw new SyncValidationException("!time: $time");
        }

        return 60 * ((int) $m[1]) + ((int) $m[2]);
    }

    /**
     * Convert km to meters
     * Example "1.23" => 1230
     * @param int|string $distance
     * @return int
     * @throws SyncValidationException
     */
    public function convertDistanceKmToM($distance): int
    {
        if (!is_numeric($distance)) {
            throw new SyncValidationException("!distance: $distance");
        }

        return (int) (1000 * $distance);
    }
}

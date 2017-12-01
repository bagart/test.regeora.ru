<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    /**
     * @var string
     */
    public $ext_id;

    /**
     * @var integer
     */
    public $start_minute;

    /**
     * @var integer
     */
    public $end_minute;

    /**
     * internal ID needed
     * @var string
     */
    public $ext_departure_id;

    /**
     * internal ID needed
     * @var string
     */
    public $ext_arrival_id;

    /**
     * @var integer
     */
    public $distance_meter;

    /**
     * @var integer
     */
    public $duration;

    /**
     * @var integer
     */
    public $is_industrial;


    protected $fillable = [
        'ext_id',
        'start_minute',
        'end_minute',
        'ext_departure_id',
        'ext_arrival_id',
        'distance_meter',
        'duration',
        'smena_id',
        'is_industrial',
    ];


    public function stops()
    {
        return $this->hasMany(Stop::class);
    }
}

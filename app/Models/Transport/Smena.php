<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Smena extends Model
{
    public $table = 'smeny';
    /**
     * @var integer
     */
    public $smena;

    /**
     * @var integer
     */
    public $graph_id;

    protected $fillable = [
        'smena',
        'graph_id',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }


}

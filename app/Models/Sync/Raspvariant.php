<?php

namespace App\Models\Sync;

use App\Models\Transport\Graph;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Raspvariant extends Model
{
    use SoftDeletes;


    /**
     * @var string
     */
    public $snapTime;

    /**
     * @var integer
     */
    public $num;

    /**
     * @var string
     */
    public $start;

    /**
     * @var string|null
     */
    public $end;

    /**
     * @var string|null
     */
    public $dow;

    /**
     * internal ID needed
     * @var string
     */
    public $ext_mr_id;

    /**
     * internal ID needed
     * @var string
     */
    public $ext_mr_num;

    protected $fillable = [
        'snapTime',
        'num',
        'start',
        'end',
        'dow',
        'ext_mr_id',
        'ext_mr_num',
    ];


    public function graphs()
    {
        return $this->hasMany(Graph::class);
    }
}

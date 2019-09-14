<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperationLog.
 *
 * @package namespace App\Entities;
 */
class OperationLog extends Model implements Transformable
{
    use TransformableTrait;

    protected $guarded = [];

    /**
     * 属于一个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}

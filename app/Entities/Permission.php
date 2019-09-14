<?php

namespace App\Entities;

use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Permission\Models\Permission as PermissionModel;

/**
 * Class Permission.
 *
 * @package namespace App\Entities;
 */
class Permission extends PermissionModel implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'guard_name', 'display_name', 'route', 'icon_id', 'parent_id'];

    public function icon()
    {
        return $this->belongsTo(Icon::class, 'icon_id', 'id');
    }

    //子权限
    public function childs()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id');
    }
}

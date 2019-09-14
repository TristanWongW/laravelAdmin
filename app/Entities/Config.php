<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Config.
 *
 * @package namespace App\Entities;
 */
class Config extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key','value','inc_type'];

    /**
     * 获取配置信息
     * @param $inc_type
     * @return \Illuminate\Cache\CacheManager|mixed
     * @throws \Exception
     */
    public function getCache($inc_type)
    {
        $config = cache($inc_type);
        if (empty($config)) {
            $res = DB::table('configs')->where('inc_type', $inc_type)->get();
            if (!empty($res)) {
                $config = $res->pluck('value', 'key');
                cache($inc_type, $config);
            }
        }
        return $config;
    }
}

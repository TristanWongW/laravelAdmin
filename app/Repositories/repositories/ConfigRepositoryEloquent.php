<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\ConfigRepository;
use App\Entities\Config;
use App\Validators\ConfigValidator;

/**
 * Class ConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class ConfigRepositoryEloquent extends BaseRepository implements ConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Config::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 添加或更新配置
     * @param $inc_type
     * @param array $data
     * @return mixed
     */
    public function cacheConfig($inc_type, $data = [])
    {
        if(empty($data)) {// 获取
            $config = cache($inc_type);
            if(empty($config)) {
                $res = $this->scopeQuery(function($query) use($inc_type) {
                    return $query->where('inc_type', $inc_type);
                })->get();
                if(!empty($res)) {
                    $config = $res->pluck('value','key');
                    cache($inc_type, $config);
                }
            }
            return $config;
        }else {// 更新或添加
            foreach($data as $key=>$v) {
                $newArr = ['key'=>$key, 'value'=>$v, 'inc_type'=>$inc_type];
                $this->updateOrCreate(['key'=>$key], $newArr);
            }
            $res = $this->scopeQuery(function($query) use($inc_type) {
                return $query->where('inc_type', $inc_type);
            })->get();
            $config = $res->pluck('value','key');
            cache($inc_type, $config);
            return $config;
        }
    }

}

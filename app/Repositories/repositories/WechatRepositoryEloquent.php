<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\wechatRepository;
use App\Entities\Wechat;
use App\Validators\WechatValidator;

/**
 * Class WechatRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class WechatRepositoryEloquent extends BaseRepository implements WechatRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Wechat::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

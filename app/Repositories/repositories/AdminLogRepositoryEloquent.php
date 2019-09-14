<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\AdminLogRepository;
use App\Entities\AdminLog;
use App\Validators\AdminLogValidator;

/**
 * Class AdminLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class AdminLogRepositoryEloquent extends BaseRepository implements AdminLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdminLog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

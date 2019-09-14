<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\user_logRepository;
use App\Entities\UserLog;
use App\Validators\UserLogValidator;

/**
 * Class UserLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class UserLogRepositoryEloquent extends BaseRepository implements UserLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserLog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

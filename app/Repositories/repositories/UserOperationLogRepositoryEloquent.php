<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\user_operation_logRepository;
use App\Entities\UserOperationLog;
use App\Validators\UserOperationLogValidator;

/**
 * Class UserOperationLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class UserOperationLogRepositoryEloquent extends BaseRepository implements UserOperationLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserOperationLog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

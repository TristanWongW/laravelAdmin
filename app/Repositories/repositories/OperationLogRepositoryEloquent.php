<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\OperationLogRepository;
use App\Entities\OperationLog;
use App\Validators\OperationLogValidator;

/**
 * Class OperationLogRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class OperationLogRepositoryEloquent extends BaseRepository implements OperationLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationLog::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

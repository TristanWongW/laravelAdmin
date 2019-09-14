<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\distributionRepository;
use App\Entities\Distribution;
use App\Validators\DistributionValidator;

/**
 * Class DistributionRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class DistributionRepositoryEloquent extends BaseRepository implements DistributionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Distribution::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

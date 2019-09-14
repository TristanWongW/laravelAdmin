<?php

namespace App\Repositories\repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\releaseRepository;
use App\Entities\Release;
use App\Validators\ReleaseValidator;

/**
 * Class ReleaseRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class ReleaseRepositoryEloquent extends BaseRepository implements ReleaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Release::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

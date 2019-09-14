<?php

namespace App\Repositories\interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ConfigRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface ConfigRepository extends RepositoryInterface
{
    //
    public function cacheConfig($inc_type, $data = []);
}

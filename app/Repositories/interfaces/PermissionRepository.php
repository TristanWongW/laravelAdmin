<?php

namespace App\Repositories\interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PermissionRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface PermissionRepository extends RepositoryInterface
{
    public function tree($list = [], $pk = 'id', $pid = 'parent_id', $child = '_child', $root = 0);
}

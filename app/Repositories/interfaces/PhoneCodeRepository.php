<?php

namespace App\Repositories\interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PhoneCodeRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface PhoneCodeRepository extends RepositoryInterface
{
    public function sendCode($phone, $type);
    public function checkPhoneCode($phone, $code, $type);
}

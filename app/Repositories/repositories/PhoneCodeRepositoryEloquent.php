<?php

namespace App\Repositories\repositories;

use App\Entities\PhoneCode;
use App\Repositories\interfaces\PhoneCodeRepository;
use App\Validators\PhoneCodeValidator;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PhoneCodeRepositoryEloquent.
 *
 * @package namespace App\Repositories\repositories;
 */
class PhoneCodeRepositoryEloquent extends BaseRepository implements PhoneCodeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PhoneCode::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 短信验证码
     * @param $phone
     * @param $type 1-后端 2-客户端 3-商户端
     * @return array
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function sendCode($phone, $type)
    {
        $delay_minutes = 5;
        $code = mt_rand(11111, 99999);
//        //短信接口
//        $uid = 'SKWL004397';
//        $passwd = '123456@cjxt';
//        //短信内容 $message
//        $message = "尊敬的用户，您本次的验证码为：" . $code . "，" . $delay_minutes . "分钟内有效。如非本人操作请忽略本信息。【申控物联】";
//        $message = iconv('UTF-8', 'GB2312', $message);
//        $gateway = 'https://sdk2.028lk.com/sdk2/BatchSend2.aspx?CorpID=' . $uid . '&Pwd=' . $passwd . '&Mobile=' . $phone . '&Content=' . $message . '&SendTime=';
//        $result = file_get_contents($gateway);
//        $result = $result > 0 ? true : false;
        $result = true;
        if ($result) {
            DB::table('phone_codes')->where('phone', $phone)->where('type', $type)->update(['is_use' => 1]);
            $this->create(['phone' => $phone, 'code' => $code, 'type' => $type]);
        }
        return ['code' => $result ? 0 : 1001, 'msg' => $result ? '发送成功' . $code : '发送频繁,请再等一个小时'];
    }

    /**
     * 验证手机验证码
     * @param $phone
     * @param $code
     * @param $type 1-后端 2-客户端 3-商户端
     * @return array
     */
    public function checkPhoneCode($phone, $code, $type)
    {
        $delay_minutes = 5;
        $phone_info = $this->scopeQuery(function ($query) use ($phone, $code, $type) {
            return $query->where(['phone' => $phone, 'code' => $code, 'is_use' => 0, 'type' => $type]);
        })->orderBy('created_at', 'desc')->first();
        if (empty($phone_info)) {
            return ['code' => 1001, 'msg' => '验证码错误'];
        }
        if ((strtotime($phone_info['created_at']) + $delay_minutes * 60) < time()) {
            return ['code' => 1001, 'msg' => '验证码已过期'];
        }
        DB::table('phone_codes')->where(['phone' => $phone, 'code' => $code, 'is_use' => 0, 'type' => $type])->update(['is_use' => 1]);
        return ['code' => 0, 'msg' => '验证通过'];
    }
}

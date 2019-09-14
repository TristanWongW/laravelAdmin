<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 所有执行完了后执行该操作
        $this->addOperationLogs($request);

        return $response;
    }

    protected function addOperationLogs($request)
    {
        if ('GET' != $request->method()) {
            $data = [
                'admin_id' => Auth::guard('admin')->user()->id,
                'path' => $request->path(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'input' => json_encode($request->all(), JSON_UNESCAPED_UNICODE)
            ];
            $OperationLogEntity = new \App\Entities\OperationLog();
            $OperationLogEntity->create($data);
        }
    }

}

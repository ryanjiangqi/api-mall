<?php

function success($data = [], $dataName = 'data', $message = 'success', $status = 1)
{
    return response()->json(['message' => $message, 'code' => $status, "{$dataName}" => $data], 200);
}
function error($msg = '未知错误', $code = 0, $httpStatus = 422)
{
    return response()->json(['message' => $msg, 'code' => $code, 'data' => ''], $httpStatus);
}
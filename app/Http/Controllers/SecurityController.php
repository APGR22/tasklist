<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    public static function SecureInputUser($data, $rules, $messages = [], $attributes = [])
    {
        //https://laracasts.com/discuss/channels/laravel/best-way-to-sanitize-user-input?page=1&replyId=948841
        $validator = Validator::make($data, $rules, $messages, $attributes);
        if ($validator->fails())
        {
            return -1;
        }

        return 0;
    }
}

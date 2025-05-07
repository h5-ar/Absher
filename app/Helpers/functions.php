<?php

use App\Enums\Role;
use App\Models\User;
use App\Models\Setting;
use App\Models\Translation;
use App\Jobs\SendNotificationJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('translate')) {
    function translate($key, $fileName = 'translation')
    {
        $translateKey = "$fileName." . str()->slug(str()->lower($key));

        $word =  __($translateKey);

        if ($translateKey === $word)
            return $key;

        return $word;
    }
}

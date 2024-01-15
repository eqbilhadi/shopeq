<?php

namespace App\Models;

use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog as RappasoftAuthenticationLog;
use Jenssegers\Agent\Agent;

class AuthenticationLog extends RappasoftAuthenticationLog
{
    public function getPlatformAttribute()
    {
        $agent = new Agent();

        return $agent->platform($this->attributes['user_agent']);
    }

    public function getBrowserAttribute()
    {
        $agent = new Agent();

        return $agent->browser($this->attributes['user_agent']);
    }

    public function getDeviceIconAttribute()
    {
        $agent = new Agent();
        $agent->setUserAgent($this->attributes['user_agent']);

        if($agent->isPhone()) {
            return '<div class="avatar-title bg-light text-primary rounded-3 fs-18">
                        <i class="fa-solid fa-mobile-notch"></i>
                    </div>';
        } else {
            return '<div class="avatar-title bg-light text-primary rounded-3 fs-18">
                        <i class="fa-sharp fa-solid fa-desktop"></i>
                    </div>';
        }
    }
}

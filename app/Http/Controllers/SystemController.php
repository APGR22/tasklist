<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SystemController extends Controller
{
    /**
     * @param \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public static function view($view)
    {
        if (self::isMaintenanceScheduled())
        {
            $schedule = env('APP_VAR_SYSTEM_MAINTENANCE_SCHEDULE');
            return $view->with('system_message', "The Maintenance Mode will be started at {$schedule}");
        }

        return $view;
    }

    public static function isMaintenanceScheduled()
    {
        $schedule = env('APP_VAR_SYSTEM_MAINTENANCE_SCHEDULE');

        return is_string($schedule);
    }

    public static function isInMaintenance()
    {
        if (!self::isMaintenanceScheduled()) return false;

        $schedule = env('APP_VAR_SYSTEM_MAINTENANCE_SCHEDULE');
        $time_format = env('APP_VAR_TIME_FORMAT');

        $schedule_time = Carbon::createFromFormat($time_format, $schedule);
        $now = Carbon::now();

        return $now->gte($schedule_time);
    }
}

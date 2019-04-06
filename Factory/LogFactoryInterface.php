<?php

namespace App\Modules\Request\Log\Factory;

use Spatie\Activitylog\Models\Activity;

interface LogFactoryInterface
{
    public function create(Activity $log);
}

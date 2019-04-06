<?php

namespace App\Modules\Request\Log;

class ReminderExpiredlog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Follow up expired';
    }
}

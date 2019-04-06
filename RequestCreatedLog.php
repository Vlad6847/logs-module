<?php

namespace App\Modules\Request\Log;

class RequestCreatedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Request created';
    }
}

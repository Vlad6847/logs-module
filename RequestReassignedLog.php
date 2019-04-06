<?php

namespace App\Modules\Request\Log;

class RequestReassignedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Request ' . $this->subject->id .  ' assigned to Agent ID ' . $this->properties['attributes']['user_id'];
    }
}

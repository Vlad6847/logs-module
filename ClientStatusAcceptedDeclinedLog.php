<?php

namespace App\Modules\Request\Log;

class ClientStatusAcceptedDeclinedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        $action = 'accepted';
        $comment = '';

        if ($this->properties['attributes']['approval_decline_comment']) {
            $comment = ', with comment: ' . $this->properties['attributes']['approval_decline_comment'];
        }

        if ($this->properties['old']['status'] !== $this->properties['attributes']['status']) {
            $action = 'declined';
        }
        
        return 'Client ' . $this->subject->id . ' change status ' . $action . $comment;
    }
}

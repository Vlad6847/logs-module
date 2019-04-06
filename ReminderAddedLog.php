<?php

namespace App\Modules\Request\Log;

class ReminderAddedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        $comment = '';

        if ($this->properties['attributes']['comment']) {
            $comment = ', with comment: ' . $this->properties['attributes']['comment'];
        }

        return 'Reminder added to: ' . $this->properties['attributes']['expires_at'] . $comment;
    }
}

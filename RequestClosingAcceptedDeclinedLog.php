<?php

namespace App\Modules\Request\Log;

class RequestClosingAcceptedDeclinedLog extends BaseLog
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

        if (null === $this->properties['attributes']['remove_reason']) {
            $action = 'declined';
        }

        return 'Request ' . $this->subject->id . ' closing ' . $action . $comment;
    }
}

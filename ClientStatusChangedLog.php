<?php

namespace App\Modules\Request\Log;

class ClientStatusChangedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        $comment = '';

        if ($this->properties['attributes']['status_comment']) {
            $comment = ', with comment: ' . $this->properties['attributes']['status_comment'];
        }

        return 'Client type changed from ' . ucfirst($this->properties['old']['status']) . ' to '
            . ucfirst($this->properties['attributes']['status']) . $comment;
    }
}

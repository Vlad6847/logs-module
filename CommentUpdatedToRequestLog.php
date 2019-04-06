<?php

namespace App\Modules\Request\Log;

class CommentUpdatedToRequestLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Comment updated from: "' . $this->properties['old']['comment'] . '" to: "'
            . $this->properties['attributes']['comment'] . '"';
    }
}

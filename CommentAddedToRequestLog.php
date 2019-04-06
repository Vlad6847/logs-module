<?php

namespace App\Modules\Request\Log;

class CommentAddedToRequestLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Comment added: "' . $this->properties['attributes']['comment'] . '"';
    }
}

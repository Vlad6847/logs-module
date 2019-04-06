<?php

namespace App\Modules\Request\Log;

class PriceQuoteSentLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Price Quote with ID ' . $this->subject->id . ' sent to client';
    }
}

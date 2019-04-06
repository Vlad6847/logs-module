<?php

namespace App\Modules\Request\Log;

class PriceQuoteSoldLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Price Quote ' . $this->subject->id . ' sold';
    }
}

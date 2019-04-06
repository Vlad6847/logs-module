<?php

namespace App\Modules\Request\Log;

class PriceQuoteCreatedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Price quote with ID ' . $this->subject->id . ' created';
    }
}

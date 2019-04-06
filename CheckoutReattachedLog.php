<?php

namespace App\Modules\Request\Log;

class CheckoutReattachedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        return 'Price Quote with ID '. $this->properties['old']['price_quote_id'] .' reattached';
    }
}

<?php

namespace App\Modules\Request\Log;

class PriceQuoteAdjustedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        $priceQuoteId = $this->properties['attributes']['price_quote_id']
            ? $this->properties['attributes']['price_quote_id']
            : $this->properties['attributes']['price_quote_segment_id'];

        return 'Price Quote with ID ' . $priceQuoteId . ' adjusted';
    }
}

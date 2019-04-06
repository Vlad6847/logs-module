<?php

namespace App\Modules\Request\Log;

use App\Models\Airport;

class FlightSegmentUpdatedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        $result = ':<p></p>';
        $attributes = collect($this->properties['attributes'])->only(['departure_id', 'arrival_id']);
        $old = collect($this->properties['old'])->only(['departure_id', 'arrival_id']);

        $diff = $attributes->diff($old);

        $diff->map(function ($item, $key) use (&$result, $old) {
            if ('departure_id' === $key || 'arrival_id' === $key) {
                $result .= '<p class="ml10">'
                    . ucfirst(str_replace('_id', ': ', $key))
                    . Airport::find($old[$key])->iata . ' -> ' . Airport::find($item)->iata . '</p>';
            }
        });

        return 'Flight segments modified' . (':<p></p>' === $result ? '' : $result);
    }
}

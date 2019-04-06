<?php

namespace App\Modules\Request\Log;

use App\Enums\RequestRemoveReasonType;
use App\Enums\RequestStatusType;
use App\Service\RequestRemoveReasonService;

class RequestClosedLog extends BaseLog
{
    /**
     * @return string
     */
    public function getAction()
    {
        if (RequestStatusType::TRAVEL_DATES_PASSED === $this->properties['attributes']['remove_reason']) {
            return 'Request closed - '
                . RequestStatusType::getDescription($this->properties['attributes']['remove_reason']);
        }

        $comment = '';
        $closedBy = (new RequestRemoveReasonService())
            ->getStatusByRemoveReason($this->properties['attributes']['remove_reason']);

        if (RequestStatusType::REQUEST_MARKERS !== $closedBy) {
            $closedBy = 'Valid reasons';
        } else {
            $closedBy = RequestStatusType::getDescription($closedBy);
        }

        if ($this->properties['attributes']['remove_reason_comment']) {
            $comment = ', with comment: ' . $this->properties['attributes']['remove_reason_comment'];
        }

        return 'Request closed using ' . $closedBy . ' - '
            . RequestRemoveReasonType::getDescription($this->properties['attributes']['remove_reason']) . $comment;
    }
}

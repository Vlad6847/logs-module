<?php

namespace App\Modules\Request\Log\Factory;

use App\Enums\PriceQuoteStatusType;
use App\Enums\RequestStatusType;
use App\Models\Checkout;
use App\Models\Client;
use App\Models\FlightSegment;
use App\Models\Passenger;
use App\Models\PriceQuote;
use App\Models\PriceQuoteSegment;
use App\Models\Request;
use App\Models\RequestReminder;
use App\Modules\Request\Log\BaseLog;
use App\Modules\Request\Log\CheckoutReattachedLog;
use App\Modules\Request\Log\ClientStatusAcceptedDeclinedLog;
use App\Modules\Request\Log\ClientStatusChangedLog;
use App\Modules\Request\Log\CommentAddedToRequest;
use App\Modules\Request\Log\CommentAddedToRequestLog;
use App\Modules\Request\Log\CommentUpdatedToRequest;
use App\Modules\Request\Log\CommentUpdatedToRequestLog;
use App\Modules\Request\Log\FlightSegmentUpdated;
use App\Modules\Request\Log\FlightSegmentUpdatedLog;
use App\Modules\Request\Log\PriceQuoteAdjustedLog;
use App\Modules\Request\Log\PriceQuoteCreated;
use App\Modules\Request\Log\PriceQuoteCreatedLog;
use App\Modules\Request\Log\PriceQuoteSent;
use App\Modules\Request\Log\PriceQuoteSentLog;
use App\Modules\Request\Log\PriceQuoteSold;
use App\Modules\Request\Log\PriceQuoteSoldLog;
use App\Modules\Request\Log\ReminderAdded;
use App\Modules\Request\Log\ReminderAddedLog;
use App\Modules\Request\Log\ReminderExpired;
use App\Modules\Request\Log\ReminderExpiredlog;
use App\Modules\Request\Log\RequestClosed;
use App\Modules\Request\Log\RequestClosedLog;
use App\Modules\Request\Log\RequestClosingAcceptedDeclined;
use App\Modules\Request\Log\RequestClosingAcceptedDeclinedLog;
use App\Modules\Request\Log\RequestCreated;
use App\Modules\Request\Log\RequestCreatedLog;
use App\Modules\Request\Log\RequestReassigned;
use App\Modules\Request\Log\RequestReassignedLog;
use Spatie\Activitylog\Models\Activity;

/**
 * Class LogFactory
 * @package App\Modules\Request\Log\Factory
 */
class LogFactory implements LogFactoryInterface
{
    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function create(Activity $log)
    {
        if (Passenger::class === $log->subject_type) {
            return $this->getPassengerLog($log);
        } elseif (PriceQuoteSegment::class === $log->subject_type) {
            return $this->getPriceQuoteSegmentLog($log);
        } elseif (FlightSegment::class === $log->subject_type) {
            return $this->getFlightSegmentLog($log);
        } elseif (Checkout::class === $log->subject_type) {
            return $this->getCheckoutLog($log);
        } elseif (PriceQuote::class === $log->subject_type) {
            return $this->getPriceQuoteLog($log);
        } elseif (Request::class === $log->subject_type) {
            return $this->getRequestLog($log);
        } elseif (Client::class === $log->subject_type) {
            return $this->getClientLog($log);
        } elseif (RequestReminder::class === $log->subject_type) {
            return $this->getRequestReminderLog($log);
        }
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getPassengerLog(Activity $log): ?BaseLog
    {
        if (isset($log->properties['old'])
            && array_diff($log->properties['attributes'], $log->properties['old'])) {
            return new PriceQuoteAdjustedLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getPriceQuoteSegmentLog(Activity $log): ?BaseLog
    {
        if (isset($log->properties['old'])
            && array_diff($log->properties['attributes'], $log->properties['old'])) {
            return new PriceQuoteAdjustedLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getFlightSegmentLog(Activity $log): ?BaseLog
    {
        if (isset($log->properties['old'])
            && array_diff($log->properties['attributes'], $log->properties['old'])) {
            return new FlightSegmentUpdatedLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getCheckoutLog(Activity $log): ?BaseLog
    {
        if (isset($log->properties['old'])
            && $log->properties['attributes']['price_quote_id'] !== $log->properties['old']['price_quote_id']) {
            return new CheckoutReattachedLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getPriceQuoteLog(Activity $log): ?BaseLog
    {
        switch ($log) {
            case 'created' === $log->description:
                return new PriceQuoteCreatedLog($log);
            case PriceQuoteStatusType::SENT === $log->properties['attributes']['status']
                && $log->properties['attributes']['status'] !== $log->properties['old']['status']:
                return new PriceQuoteSentLog($log);
            case PriceQuoteStatusType::SOLD === $log->properties['attributes']['status']
                && $log->properties['attributes']['status'] !== $log->properties['old']['status']:
                return new PriceQuoteSoldLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getRequestLog(Activity $log): ?BaseLog
    {
        switch ($log) {
            case 'created' === $log->description:
                return new RequestCreatedLog($log);
            case $log->properties['old']['comment'] === null && $log->properties['attributes']['comment'] !== null:
                return new CommentAddedToRequestLog($log);
            case $log->properties['old']['comment'] !== $log->properties['attributes']['comment']:
                return new CommentUpdatedToRequestLog($log);
            case $log->properties['attributes']['user_id'] !== $log->properties['old']['user_id']:
                return new RequestReassignedLog($log);
            case null === $log->properties['old']['remove_reason']
                && $log->properties['attributes']['remove_reason'] !== null:
                return new RequestClosedLog($log);
            case true == $log->properties['old']['need_approval']
                && $log->properties['attributes']['need_approval'] == false:
                return new RequestClosingAcceptedDeclinedLog($log);
            case $log->properties['attributes']['status'] === RequestStatusType::FOLLOW_UP_EXPIRED &&
                $log->properties['attributes']['status'] !== $log->properties['old']['status']:
                return new ReminderExpiredLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getClientLog(Activity $log): ?BaseLog
    {
        switch ($log) {
            case isset($log->properties['old'])
                && $log->properties['attributes']['status'] !== $log->properties['old']['status']
                && true == $log->properties['attributes']['need_approval']:
                return new ClientStatusChangedLog($log);
            case isset($log->properties['old']) && true == $log->properties['old']['need_approval']
                && false == $log->properties['attributes']['need_approval']:
                return new ClientStatusAcceptedDeclinedLog($log);
        }

        return null;
    }

    /**
     * @param Activity $log
     * @return null|BaseLog
     */
    public function getRequestReminderLog(Activity $log): ?BaseLog
    {
        if (!isset($log->properties['old'])) {
            return new ReminderAddedLog($log);
        }

        return null;
    }
}

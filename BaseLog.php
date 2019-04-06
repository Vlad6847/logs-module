<?php

namespace App\Modules\Request\Log;

use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;

abstract class BaseLog
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var object
     */
    protected $subject;

    /**
     * @var object
     */
    protected $causer;

    /**
     * @var Collection
     */
    protected $properties;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * BaseLog constructor.
     * @param Activity $log
     */
    public function __construct(Activity $log)
    {
        $this->description = $log->description;
        $this->subject = $log->subject;
        $this->properties = $log->properties;
        $this->createdAt = $log->created_at;
        $this->causer = $log->causer;
    }

    /**
     * @return Object
     */
    public function getCauser()
    {
        return $this->causer;
    }

    /**
     * @return string
     */
    abstract public function getAction();

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return object
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return Collection
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}

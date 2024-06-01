<?php

namespace App\Models;

use Hamcrest\Type\IsBoolean;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;

class Appoinment extends BaseModel
{
    public string $date;
    public string $patientId;
    public string $doctorId;
    public string $timeId;
    public bool $status;

    /**
     * @param string $userid
     */
    public function __construct(string $patientId, string $doctorId,  string $date, string $id, bool $status)
    {
        parent::__construct();
        $this->patientId = $patientId;
        $this->doctorId = $doctorId;
        $this->date = $date;
        $this->timeId = $id;
        $this->status = $status;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getDocterId(): string
    {
        return $this->doctorId;
    }

    public function getTimeId(): string
    {
        return $this->timeId;
    }

    public function getDate(): string
    {
        return $this->date;
    }
    public function getStatus()
    {
        return $this->status === null ? "0" : $this->status;
    }
}
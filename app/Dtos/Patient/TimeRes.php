<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;
/**
 * @OA\Schema(
 *     schema="TimeRes",
 *     type="object",
 *     title="TimeRes",
 *     description="Response object for available times",
 *     required={"id", "timeStart", "timeEnd", "price", "calendarId"}
 * )
 */
class TimeRes
{
    /**
     * @OA\Property(
     *     description="ID of the time slot",
     *     type="string"
     * )
     */
    public string $id;

    /**
     * @OA\Property(
     *     description="Start time of the slot",
     *     type="string",
     *     format="time"
     * )
     */
    public string $timeStart;

    /**
     * @OA\Property(
     *     description="End time of the slot",
     *     type="string",
     *     format="time"
     * )
     */
    public string $timeEnd;

    /**
     * @OA\Property(
     *     description="Price of the time slot",
     *     type="string"
     * )
     */
    public string $price;

    /**
     * @OA\Property(
     *     description="Calendar ID associated with the slot",
     *     type="string"
     * )
     */
    public string $calendarId;

    public function __construct(string $id, string $timeStart, string $timeEnd, string $price, string $calendarId)
    {
        $this->id = $id;
        $this->timeStart = $timeStart;
        $this->timeEnd = $timeEnd;
        $this->price = $price;
        $this->calendarId = $calendarId;
    }
}

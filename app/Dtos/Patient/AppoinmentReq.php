<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="AppoinmentReq",
 *     type="object",
 *     title="AppoinmentReq",
 *     description="Request object for creating an appointment",
 *     required={"date", "patientId", "doctorId", "CalendarId"}
 * )
 */
class AppoinmentReq
{
    /**
     * @OA\Property(
     *     description="Date of the appointment",
     *     type="string",
     *     format="date"
     * )
     */
    public string $date;

    /**
     * @OA\Property(
     *     description="ID of the patient",
     *     type="string"
     * )
     */
    public string $patientId;

    /**
     * @OA\Property(
     *     description="ID of the doctor",
     *     type="string"
     * )
     */
    public string $doctorId;

    /**
     * @OA\Property(
     *     description="ID of the calendar",
     *     type="string"
     * )
     */
    public string $CalendarId;

    public function __construct(Request $req)
    {
        $this->date = $req->input("date");
        $this->patientId = $req->input("patientId");
        $this->doctorId = $req->input("doctorId");
        $this->CalendarId = $req->input("calendarId");
    }
}

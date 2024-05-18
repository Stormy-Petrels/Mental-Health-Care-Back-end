<?php

namespace App\Dtos\Patient;

use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="CheckTimeReq",
 *     type="object",
 *     title="CheckTimeReq",
 *     description="Request object for checking available times",
 *     required={"date", "doctorId"}
 * )
 */
class CheckTimeReq
{
    /**
     * @OA\Property(
     *     description="Date for checking available times",
     *     type="string",
     *     format="date"
     * )
     */
    public string $date;

    /**
     * @OA\Property(
     *     description="ID of the doctor",
     *     type="string"
     * )
     */
    public string $doctorId;

    public function __construct(Request $req)
    {
        $this->date = $req->input("date");
        $this->doctorId = $req->input("doctorId");
    }
}

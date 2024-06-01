<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Dtos\Patient\AppoinmentReq;
use App\Repositories\DoctorRepository;
use App\Dtos\Patient\CheckTimeReq;
use App\Dtos\Patient\TimeRes;
use Illuminate\Http\Request;
use App\Dtos\Patient\BookingReq;
use App\Models\Appoinment;
use App\Repositories\AppoinmentsRepository;
use App\Models\Booking;

class AppoinmentController extends Controller
{
    private DoctorRepository $doctorRepository;
    private AppoinmentsRepository $appoinmentRepository;

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
        $this->appoinmentRepository = new AppoinmentsRepository();
    }

    /**
     * @OA\Post(
     *     path="/api/time",
     *     summary="Check available times for booking",
     *     tags={"Patient"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CheckTimeReq")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="List of available times",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="listTime", type="array", @OA\Items(ref="#/components/schemas/TimeRes"))
     *         )
     *     )
     * )
     */
    public function checkTime(CheckTimeReq $req)
    {
        $listTime = $this->doctorRepository->getAvailableTimesForBooking($req->date, $req->doctorId);
        $collection = collect($listTime);
        // dd($collection);
        $Times = $collection->map(function ($time) {
            return new TimeRes(
                $time->id,
                $time->timeStart,
                $time->timeEnd,
                $time->price,
                $time->id
            );
        });
        return response()->json([
            'message' => 'List time user',
            'listTime' => $Times
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/appoinment",
     *     summary="Create a new appointment",
     *     tags={"Patient"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AppoinmentReq")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="You have successfully booked your appointment",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function appoinment(AppoinmentReq $req)
    {
        if ($req->CalendarId == "") {
            return response()->json([
                'message' => 'Appointment failed',
            ], 404);
        }
        $newBooking = new Appoinment($req->patientId, $req->doctorId, $req->date, $req->CalendarId, $req->status);
        $this->appoinmentRepository->insert($newBooking);
        return response()->json([
            'message' => 'You have successfully booked your appointment',
        ], 200);
    }
    public function getAppointments(){
        $appointments = $this->appoinmentRepository->selectAllAppointment();
        return response()->json([
            'message' => 'list appointment',
            'appointments' => $appointments
        ], 200);
    }

    public function getTotalAppointment(){
        $appointments = $this->appoinmentRepository->selectAllAppointment();
        $total = $this->appoinmentRepository->totalAppointmentDoctor($appointments);
        return response()->json([
            'message' => 'list totleAppointment',
            'totalApointments' => $total
        ], 200);
    }
}

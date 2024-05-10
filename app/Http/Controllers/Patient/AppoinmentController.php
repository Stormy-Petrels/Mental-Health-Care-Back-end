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

    public function __construct()
    {
        $this->doctorRepository = new DoctorRepository();
    }

    
    public function checkTime(CheckTimeReq $req)
    {
        $listTime = $this->doctorRepository->getAvailableTimesForBooking($req->date, $req->doctorId);
        $collection = collect($listTime);
        $Times = $collection->map(function ($time) {
            return new TimeRes(
                $time->id,
                $time->timeStart,
                $time->timeEnd,
                $time->price
            );
        });
        return response()->json([
            'message' => 'List time user',
            'listTime' => $Times
        ], 201);
    }

}
<?php

namespace App\Repositories;

use App\Models\Appoinment;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Dtos\Admin\AppointmentRes;
use App\Dtos\Patient\AppointmentHistoryRes;
use App\Dtos\Admin\ChartRes;

class AppoinmentsRepository
{
    private string $tableName = "appoinments"; 

    public function insert(Appoinment $appoinment)
    {
        $sql = "INSERT INTO $this->tableName (id,patientId,doctorId,dateBooking,calendarId,status) VALUES (?, ?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $appoinment->getId(),
            $appoinment->getPatientId(),
            $appoinment->getDocterId(),
            $appoinment->getDate(),
            $appoinment->getTimeId(),
            $appoinment->getStatus(),
        ]);
    }

    public function check()
    {
        $duplicates = DB::table('booking')
            ->select('doctor_id', 'date_booking', 'time_id')
            ->groupBy('doctor_id', 'date_booking', 'time_id')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('add_to_cart')
                ->where('doctor_id', $duplicate->doctor_id)
                ->where('date_booking', $duplicate->date_booking)
                ->where('time_id', $duplicate->time_id)
                ->delete();
        }
    }

    public function selectAllAppointment()
{
    try {
        $appointments = DB::table('appoinments as a')
            ->join('patients as p', 'a.patientId', '=', 'p.id')
            ->join('users as u1', 'p.userId', '=', 'u1.id')
            ->join('doctors as d', 'a.doctorId', '=', 'd.id')
            ->join('users as u2', 'd.userId', '=', 'u2.id')
            ->join('calendars as c', 'a.calendarId', '=', 'c.id')
            ->join('listtimedoctors as lt', 'c.timeId', '=', 'lt.id')
            ->select(
                'a.id as appointmentId',
                'a.dateBooking as date',
                'u1.fullName as patientName',
                'u2.fullName as doctorName',
                'lt.timeStart as timeStart',
                'lt.timeEnd as timeEnd'
            )
            ->get();

        $collection = collect($appointments);
        $objectAppointments = $collection->map(function ($appointment) {
            return new AppointmentRes(
                $appointment->appointmentId,
                $appointment->patientName,
                $appointment->doctorName,
                $appointment->date,
                $appointment->timeStart,
                $appointment->timeEnd
            );
        });
        return $objectAppointments;
    } catch (\Exception $e) {
        return collect();
    }
}


public function totalAppointmentDoctor($appointments)
{
    try {
        $doctorCounts = collect($appointments)
            ->groupBy('doctorName')
            ->map(function ($appointments, $doctorName) {
                return [
                    'doctorName' => $doctorName,
                    'totalCount' => $appointments->count()
                ];
            })
            ->values()
            ->toArray();

        $doctorCollect = collect($doctorCounts);
        $result = $doctorCollect->map(function ($item) {
            return new ChartRes(
                $item['doctorName'],
                $item['totalCount']
            );
        });

        return $result;
    } catch (\Exception $e) {
        return collect();
    }
}


    public function get_patient_id($email)
    {
        $user = DB::select('SELECT id FROM users WHERE email = ? LIMIT 1', [$email]);

        if (!empty($user)) {
            $userId = $user[0]->id;

            $patient = DB::select('SELECT id FROM patients WHERE user_id = ?', [$userId]);

            if (!empty($patient)) {
                $patientId = $patient[0]->id;

                $bookings = DB::select('SELECT b.id, b.patient_id, b.doctor_id, b.date_booking, b.time_id, u.email, u.name, u.phone, t.time_start, t.price
                FROM booking b  
                INNER JOIN doctors d ON b.doctor_id = d.id
                INNER JOIN users u ON d.user_id = u.id
                INNER JOIN list_time_doctor t ON b.time_id = t.id
                WHERE b.patient_id = ?', [$patientId]);

                if (!empty($bookings)) {
                    return $bookings;
                } else {
                    return "No record found in booking table";
                }
            } else {
                return "No records found in patients table";
            }
        } else {
            return "No user found with this email";
        }
    }

    public function getAppointmentHistory($id)
{
    try {
        $appointments = DB::table('appoinments as a')
            ->join('patients as p', 'a.patientId', '=', 'p.id')
            ->join('users as u1', 'p.userId', '=', 'u1.id')
            ->join('doctors as d', 'a.doctorId', '=', 'd.id')
            ->join('users as u2', 'd.userId', '=', 'u2.id')
            ->join('calendars as c', 'a.calendarId', '=', 'c.id')
            ->join('listtimedoctors as lt', 'c.timeId', '=', 'lt.id')
            ->where('p.id', '=', $id)
            ->select(
                'a.id as appointmentId',
                'a.dateBooking as date',
                'a.status',
                'u1.fullName as patientName',
                'u2.urlImage as image',
                'u2.fullName as doctorName',
                'lt.timeStart as timeStart',
                'lt.timeEnd as timeEnd',
                'lt.price as price'
            )
            ->get();

        $objectAppointments = $appointments->map(function ($appointment) {
            return new AppointmentHistoryRes(
                $appointment->appointmentId,
                $appointment->patientName,
                $appointment->doctorName,
                $appointment->image,
                $appointment->price,
                $appointment->date,
                $appointment->timeStart,
                $appointment->timeEnd,
                $appointment->status
            );
        });

        return $objectAppointments;
    } catch (\Exception $e) {
        return collect();
    }
}

    
}
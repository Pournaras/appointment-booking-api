<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Specialist;
use App\Models\Service;

class AppointmentController extends Controller
{
    //Get the appointments
    public function getAppointments(Request $request)
    {
        //Bearer token check
        if ($request->bearerToken() !== 'secret_token') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        
        //Validate the request
        $validator = Validator::make($request->all(), [
            'specialist_id' => 'nullable|integer|exists:specialists,id',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid request parameters.'
            ], 400);
        }

        $query = Appointment::where('appointment_date', $request->date);

        if ($request->filled('specialist_id')) {
            $query->where('specialist_id', $request->specialist_id);
        }

        $appointments = $query->get()->map(function ($appointment) {
            return [
                'appointment_id' => $appointment->id,
                'specialist' => $appointment->specialist->name,
                'service' => $appointment->service->name,
                'appointment_date' => \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y'),
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
            ];
        });

        return response()->json($appointments);
    }


    //Book an appointment
    public function book(Request $request)
    {
        // Check Bearer token
        if ($request->bearerToken() !== 'secret_token') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'specialist_id'    => 'required|integer|exists:specialists,id',
            'service_id'       => 'required|integer|exists:services,id',
            'appointment_date' => 'required|date',
            'start_time'       => 'required|date_format:H:i:s',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid request parameters.'
            ], 400);
        }

        //Check if specialist provides requested service
        $specialist = Specialist::find($request->specialist_id);

        if (!$specialist->services()->where('services.id', $request->service_id)->exists()) {
            return response()->json([
                'message' => 'The selected specialist does not provide the requested service.'
            ], 400);
        }

        //Calculate appointment's end time
        $service = Service::findOrFail($request->service_id);

        $startTime = Carbon::createFromFormat('H:i:s', $request->start_time);

        list($hours, $minutes, $seconds) = explode(':', $service->duration);
        $endTime = $startTime->copy()
            ->addHours((int) $hours)
            ->addMinutes((int) $minutes)
            ->addSeconds((int) $seconds);

        //Reject past dates
        if (Carbon::parse($request->appointment_date)->isBefore(Carbon::today())) {
            return response()->json([
                'message' => 'Appointment date cannot be in the past.'
            ], 400);
        }

        // Working hours: 09:00 - 18:00
        if (
            $startTime->format('H:i:s') < '09:00:00' ||
            $endTime->format('H:i:s') > '18:00:00'
        ) {
            return response()->json([
                'message' => 'Appointment must be between 09:00 and 18:00.'
            ], 400);
        }

        //Restrict appointment's start time on half-hour time slots
        $startMinutes = date('i', strtotime($request->start_time));

        if (!in_array($startMinutes, ['00', '30'])) {
            return response()->json([
                'message' => 'Appointments must start on half-hour time slots.'
            ], 400);
        }

        // Check for overlapping appointments
        $appointments = Appointment::where('specialist_id', $request->specialist_id)
            ->where('appointment_date', $request->appointment_date)
            ->get();

        foreach ($appointments as $appointment) {
            if (
                $startTime->format('H:i:s') < $appointment->end_time &&
                $endTime->format('H:i:s') > $appointment->start_time
            ) {
                return response()->json([
                    'message' => 'This time slot is already booked.'
                ], 409);
            }
        }

        // Create the appointment
        $appointment = Appointment::create([
            'specialist_id'    => $request->specialist_id,
            'service_id'       => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'start_time'       => $startTime->format('H:i:s'),
            'end_time'         => $endTime->format('H:i:s'),
        ]);

        //Create the final response
        $appointment->load('specialist', 'service');

        return response()->json([
            'message' => 'Appointment booked successfully.',
            'appointment_id' => $appointment->id,
            'specialist' => $appointment->specialist->name,
            'service' => $appointment->service->name,
            'appointment_date' => \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y'),
            'start_time' => $appointment->start_time,
            'end_time' => $appointment->end_time,
        ], 201);
    }

    //Cancel an appointment
    public function cancel(Request $request)
    {
        // Check Bearer token
        if ($request->bearerToken() !== 'secret_token') {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|integer|exists:appointments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid request parameters.'
            ], 400);
        }

        // Find the appointment
        $appointment = Appointment::findOrFail($request->appointment_id);

        // Don't allow cancellation of past appointments
        if (Carbon::parse($appointment->appointment_date)->lt(today())) {
            return response()->json([
                'message' => 'Past appointments cannot be cancelled.'
            ], 400);
        }

        // Delete the appointment
        $appointment->delete();

        return response()->json([
            'message' => 'Appointment cancelled successfully.',
            'appointment_id' => $request->appointment_id
        ]);
    }
}

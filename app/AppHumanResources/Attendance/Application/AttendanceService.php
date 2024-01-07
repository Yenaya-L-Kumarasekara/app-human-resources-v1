<?php

namespace App\AppHumanResources\Attendance\Application;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AttendanceService
{
    public function uploadAttendanceData($processedData)
    {
        foreach ($processedData as $data) {
            Attendance::create([
                'employee_id' => $data['employee_id'],
                'check_in' => $data['check_in'],
                'check_out' => $data['check_out'],
            ]);
        }
    }

    public function getEmployeeAttendanceInfo(): Collection
    {
        $attendanceInfo = Attendance::with('employee:employee_id,name') // Eager load employee data
        ->get(['employee_id', 'check_in', 'check_out']);

        $attendanceInfo->each(function ($entry) {
            $entry->total_hours = $this->calculateTotalHours($entry->check_in, $entry->check_out);
        });

        return $attendanceInfo;
    }

    private function calculateTotalHours($checkIn, $checkOut)
    {
        if ($checkIn === null || $checkOut === null) {
            return null;
        }
        
        // Implement the logic to calculate total working hours
        $checkIn = Carbon::parse($checkIn);
        $checkOut = Carbon::parse($checkOut);

        return $checkIn->diffInHours($checkOut);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppHumanResources\Attendance\Application\AttendanceService;

class AttendanceController extends Controller
{

    private $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Get all attendance records
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeAttendanceInfo(Request $request)
    {
        try{

            $attendanceInfo = $this->attendanceService->getEmployeeAttendanceInfo();

            if ($attendanceInfo->isEmpty()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'No Record Found',
                    'data' => []
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Record Found',
                'data' => $attendanceInfo
            ]);

        }catch(\Exception $e){
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ]);
        }

    }

    /**
     * Store attendance records
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadAttendance(Request $request)
    {
        $processedData = $request->input('attendance_data');

        if (empty($processedData)) {
            return response()->json([
                'status' => 400,
                'message' => 'No data found to upload'
            ]);
        }

        try {
            // Pass the processed attendance data to the service
            $this->attendanceService->uploadAttendanceData($processedData);

            return response()->json([
                'status' => 200,
                'message' => 'Attendance added successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }
}

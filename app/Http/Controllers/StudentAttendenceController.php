<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentAttendenceController extends Controller
{
    public function StudentAttendence(Request $request)
    {
        // Step 1: Validate the incoming request
        $validator = Validator::make($request->all(), [
            'lesson_id' => 'required',
            'subject' => 'required',
            'teacher_id' => 'required',
            'student_id' => 'required', // Assuming auth_id represents the student_id
            'type' => 'required',
            'lesson_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Step 2: Extract the validated data
        $data = $validator->validated();

        // Step 3: Check if the attendance record already exists
        $existingRecord = DB::table('student_attendences')
            ->where('lesson_id', $data['lesson_id'])
            ->where('student_id', $data['student_id']) // Checking for existing record by lesson_id and auth_id (student_id)
            ->first();

        // Step 4: If the record doesn't exist, insert the new attendance record
        if (!$existingRecord) {
            DB::table('student_attendences')->insert([
                'lesson_id' => $data['lesson_id'],
                'student_id' => $data['student_id'],
                'teacher_id' => $data['teacher_id'],
                'subject_id' => $data['subject'],
                'class_type' => $data['type'],
                'lesson_date' => $data['lesson_date'],
                'attendence' => 'Present',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => 'Attendance recorded successfully.']);
        } else {
            return response()->json(['message' => 'Attendance already recorded for this lesson and student.'], 409);
        }
    }


    public function StudentAttendenceData(Request $request){
        try {

            $attendences = StudentAttendence::where('student_id', $request->student_id)->where('teacher_id', $request->teacher_id)->where('subject_id', $request->subject_id)->whereMonth('lesson_date', $request->month)->get();
             
            return response()->json([
                'status' => 200,
                'message' => 'Attendence retrieved successfully',
                'data' => [
                    'attendence' => $attendences,
                ],
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => [],
            ], 400);
        } 
    }
}

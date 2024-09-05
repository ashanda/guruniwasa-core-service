<?php

namespace App\Http\Controllers;

use App\Models\StudenttermTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudenttermTestController extends Controller
{
    public function store(Request $request)
{
    // Log the incoming request for debugging purposes
    Log::info($request->all());

    // Find the existing record if it exists
    $studentRecord = StudenttermTest::where('student_id', $request->student_id)
        ->where('subject_id', $request->subject_id)
        ->first();

    // Prepare the data for insertion or update using the paths provided in the request
    $recordData = [
        'teacher_id'  => $request->teacher_id,
        'grade_id'    => $request->grade_id,
    ];

    // Conditionally update term values only if they are provided in the request
    if ($request->filled('first_term')) {
        $recordData['first_term'] = $request->first_term;
    } else if ($studentRecord) {
        $recordData['first_term'] = $studentRecord->first_term;
    }

    if ($request->filled('second_term')) {
        $recordData['second_term'] = $request->second_term;
    } else if ($studentRecord) {
        $recordData['second_term'] = $studentRecord->second_term;
    }

    if ($request->filled('third_term')) {
        $recordData['third_term'] = $request->third_term;
    } else if ($studentRecord) {
        $recordData['third_term'] = $studentRecord->third_term;
    }

    // Conditionally update marks values only if they are provided in the request
    if ($request->filled('first_marks')) {
        $recordData['first_marks'] = $request->first_marks;
    } else if ($studentRecord) {
        $recordData['first_marks'] = $studentRecord->first_marks;
    }

    if ($request->filled('second_marks')) {
        $recordData['second_marks'] = $request->second_marks;
    } else if ($studentRecord) {
        $recordData['second_marks'] = $studentRecord->second_marks;
    }

    if ($request->filled('third_marks')) {
        $recordData['third_marks'] = $request->third_marks;
    } else if ($studentRecord) {
        $recordData['third_marks'] = $studentRecord->third_marks;
    }

    // Use updateOrCreate to either update an existing record or create a new one
    $studentRecord = StudenttermTest::updateOrCreate(
        [
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
        ],
        $recordData
    );

    if ($studentRecord->wasRecentlyCreated) {
        return response()->json(['message' => 'Record created successfully'], 201);
    } else {
        return response()->json(['message' => 'Record updated successfully'], 200);
    }
}






}

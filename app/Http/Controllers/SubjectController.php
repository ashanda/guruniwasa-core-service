<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'grade' => 'required|integer', // Validate that 'grade' is required and must be an integer
            'classType' => 'required',
        ]);

        try {
            $classType = $request->input('classType') == 'free' ? 'Free' : 'Online';

            // Retrieve the grade with its related subjects
            $grade = Grade::with(['subjects' => function ($query) use ($classType) {
                $query->where('class_type', $classType);
            }])->findOrFail($request->input('grade'));

            // Return a successful response with the grade and its subjects
            return response()->json([
                'data' => $grade->subjects,
                'message' => 'Subjects for grade retrieved successfully.',
            ], 200);
        } catch (Exception $exception) {
            // Handle any exceptions and return an error response
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // If using a view to create a subject, return it here
            // return view('subjects.create');
            return response()->json([
                'message' => 'Create form loaded successfully.',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'gid' => 'required|exists:grades,id',
                'sname' => 'required|string|max:255',
                'fee' => 'required|numeric',
                'fees_valid_period' => 'required|date',
                'whats_app' => 'nullable|string',
                'class_type' => 'required|string',
                'day_normal' => 'nullable|string',
                'start_normal' => 'nullable|string',
                'end_normal' => 'nullable|string',
                'day_extra1' => 'nullable|string',
                'start_extra1' => 'nullable|string',
                'end_extra1' => 'nullable|string',
                'day_extra1_status' => 'nullable|boolean',
                'day_extra2' => 'nullable|string',
                'start_extra2' => 'nullable|string',
                'end_extra2' => 'nullable|string',
                'day_extra2_status' => 'nullable|boolean',
                'status' => 'required|boolean',
            ]);

            $subject = Subject::create($request->all());

            return response()->json([
                'data' => $subject,
                'message' => 'Subject created successfully.',
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        try {
            return response()->json([
                'data' => $subject,
                'message' => 'Subject details retrieved successfully.',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        try {
            // If using a view to edit a subject, return it here
            // return view('subjects.edit', compact('subject'));
            return response()->json([
                'data' => $subject,
                'message' => 'Edit form loaded successfully.',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        try {
            $request->validate([
                'gid' => 'required|exists:grades,id',
                'sname' => 'required|string|max:255',
                'fee' => 'required|numeric',
                'fees_valid_period' => 'required|date',
                'whats_app' => 'nullable|string',
                'class_type' => 'required|string',
                'day_normal' => 'nullable|string',
                'start_normal' => 'nullable|string',
                'end_normal' => 'nullable|string',
                'day_extra1' => 'nullable|string',
                'start_extra1' => 'nullable|string',
                'end_extra1' => 'nullable|string',
                'day_extra1_status' => 'nullable|boolean',
                'day_extra2' => 'nullable|string',
                'start_extra2' => 'nullable|string',
                'end_extra2' => 'nullable|string',
                'day_extra2_status' => 'nullable|boolean',
                'status' => 'required|boolean',
            ]);

            $subject->update($request->all());

            return response()->json([
                'data' => $subject,
                'message' => 'Subject updated successfully.',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        try {
            $subject->delete();
            return response()->json([
                
                'message' => 'Subject deleted successfully.',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }



 public function getSubjects(Request $request)
{
    

    try {
        // Validate the request data
        
        // Retrieve the validated subject IDs
        $subjectIds = $request->input('subject_ids');

        // Ensure $subjectIds is an array before processing
        

        // Query the subjects based on the provided IDs
      if (is_string($subjectIds)) {
        $subjectIds = json_decode($subjectIds, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
               // Log::error('Failed to decode JSON: ' . json_last_error_msg());
            }
        }

        // Ensure $subjectIds is an array after decoding
        if (!is_array($subjectIds)) {
           // Log::error('Expected $subjectIds to be an array, got: ' . gettype($subjectIds));
        } else {
            // Now $subjectIds should be a proper array, proceed with the query
            $subjects = Subject::whereIn('id', $subjectIds)->get();

            if ($subjects->isEmpty()) {
               // Log::warning('No subjects found for the given IDs');
            } else {
                //Log::alert($subjects->toJson());
            }
        }
        // Return the response
        return response()->json([
            'status' => 200,
            'data' => $subjects,
            'message' => 'Subjects fetched successfully.',
        ], 200);
    } catch (\Exception $exception) {
        // Handle exceptions
        return response()->json([
            'error' => $exception->getMessage(),
        ], 400);
    }
}





}

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
    public function CreateSubject(Request $request){
    
    try {
        // Validate request data
        

        //Log::info($request->all());
        // Create the subject
        $subject = Subject::create([
            'gid' => $request->gid,
            'tid' => $request->tid,
            'sname' => $request->sname,
            'fee' => $request->fee,
            'retention' => $request->retention,
            'whats_app' => $request->whats_app,
            'class_type' => $request->class_type,
            'day_normal' => $request->day_normal,
            'start_normal' => $request->start_normal,
            'end_normal' => $request->end_normal,
            'day_extra1' => $request->day_extra1,
            'end_extra1' => $request->end_extra1,
            'day_extra2' => $request->day_extra2,
            'start_extra2' => $request->start_extra2,
            'end_extra2' => $request->end_extra2,
        ]);
        
        // Fetch all subject IDs related to the provided 'tid'
        $relatedSubjectIds = Subject::where('tid', $request->tid)->pluck('id');
        Log::info($relatedSubjectIds);
        // Return the created subject and related subject IDs
        return response()->json([
            'data' => $subject,
            'related_subject_ids' => $relatedSubjectIds,  // Return the list of related IDs
            'message' => 'Subject created successfully.',
        ], 200);

    } catch (\Exception $exception) {
        // Handle any exceptions
        return response()->json([
            'error' => $exception->getMessage(),
        ], 400);
    }
}



public function UpdateSubject(Request $request)
{
    try {
        // Validate request data
        // You can add validation here as needed

        // Find the subject by 'sid'
        $subject = Subject::where('id', $request->sid)->first();

        // Check if subject exists
        if (!$subject) {
            return response()->json([
                'message' => 'Subject not found.',
            ], 404);
        }

        // Update the subject fields
        $subject->update([
            'sname' => $request->sname,
            'fee' => $request->fee,
            'retention' => $request->retention,
            'whats_app' => $request->whats_app,
            'class_type' => $request->class_type,
            'day_normal' => $request->day_normal,
            'start_normal' => $request->start_normal,
            'end_normal' => $request->end_normal,
            'day_extra1' => $request->day_extra1,
            'end_extra1' => $request->end_extra1,
            'day_extra2' => $request->day_extra2,
            'start_extra2' => $request->start_extra2,
            'end_extra2' => $request->end_extra2,
        ]);

        // Fetch all subject IDs related to the provided 'tid'
        $relatedSubjectIds = Subject::where('tid', $request->tid)->pluck('id');

        // Return the updated subject and related subject IDs
        return response()->json([
            'data' => $subject,
            'related_subject_ids' => $relatedSubjectIds,  // Return the list of related IDs
            'message' => 'Subject updated successfully.',
        ], 200);

    } catch (\Exception $exception) {
        // Handle any exceptions
        return response()->json([
            'error' => $exception->getMessage(),
        ], 400);
    }
}


public function DeleteSubject(Request $request){
    
    try {
        // Find the subject by 'sid'
        $subject = Subject::where('id', $request->sid)->first();

        // Check if subject exists
        if (!$subject) {
            return response()->json([
                'message' => 'Subject not found.',
            ], 404);
        }

        // Perform soft delete
        $subject->delete();

        return response()->json([
            'message' => 'Subject soft deleted successfully.',
        ], 200);

    } catch (\Exception $exception) {
        Log::info($exception->getMessage());
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
                // Load the grade relationship if it exists
                $subject->load('grade');

                return response()->json([
                    'data' => $subject,
                    'grade' => $subject->grade,  // Include the grade data
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



public function TeacherSubjects(Request $request){
    try {
    $request->validate([
        'teacher_id' => 'required',
    ]);
    


    
    $subjectIds = $request->input('subject_id');
    if (!is_array($subjectIds)) {
            return response()->json(['error' => 'subject_id must be an array'], 400);
        }
    
    $classSubjects = Subject::whereIn('id', $subjectIds)->select('id', 'sname', 'gid', 'class_type') ->with('grade') ->get();
 
            return response()->json([
                'status' => 200,
                'message' => 'teacher_id related subject retrieved successfully',
                'data' => [
                    'teacher_subjects' => $classSubjects,

                ],
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => [],
            ], 400);
        } 
}

public function studentSubjects(Request $request){
    try {


    $request->validate([
        
        'subject_id' => 'required',
    ]);
    


    
    $subjectIds = $request->input('subject_id');

    if (is_array($subjectIds)) {

            return response()->json(['error' => 'subject_id must be an array'], 400);
        }
    
    $classSubjects = Subject::where('id', $subjectIds)->select('id', 'sname', 'gid','tid', 'class_type','fee') ->with('grade') ->first();

            return response()->json([
                'status' => 200,
                'message' => 'student related subject retrieved successfully',
                'data' => [
                    'student_subjects' => $classSubjects,

                ],
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => [],
            ], 400);
        } 

}


public function studentSubjectsTerm(Request $request){
    try {


    $request->validate([
        
        'subject_id' => 'required',
    ]);
    


    
    $subjectIds = $request->input('subject_id');

    if (is_array($subjectIds)) {

            return response()->json(['error' => 'subject_id must be an array'], 400);
        }
    
    $classSubjects = Subject::where('id', $subjectIds)->select('id', 'sname', 'gid','tid', 'class_type') ->with('grade')->with('term') ->first();

            return response()->json([
                'status' => 200,
                'message' => 'student related subject retrieved successfully',
                'data' => [
                    'student_subjects' => $classSubjects,

                ],
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => [],
            ], 400);
        } 

}

public function studentSubjectGradeRelated(Request $request){

    $request->validate([
        'grade_id' => 'required',
    ]);

    $grade_id = $request->input('grade_id');
    try {
        $subjects = Subject::where('gid', $grade_id)->with('grade')->get();
        return response()->json([
            'status' => 200,
            'message' => 'subjects retrieved successfully',
            'data' => [
                'subjects' => $subjects,
            ],
        ], 200);
    } catch (Exception $exception) {
        return response()->json([
            'status' => 400,
            'message' => $exception->getMessage(),
            'data' => [],
        ], 400);
    }
}

public function singleSubject(Request $request){

        $request->validate([
            'subject_id' => 'required',
        ]);
        $data = Subject::where('id', $request->subject_id)->first();
        return response()->json([
                'status' => 200,
                'message' => 'Requested Subject.',
                'data' => $data,
            ], 200);
    }


 public function gradeWiseSubjects(Request $request){

    $request->validate([
        'grade_id' => 'required',
    ]);
    $data = Subject::where('gid', $request->grade_id)->get();
  
    return response()->json([
            'status' => 200,
            'message' => 'Requested Subject.',
            'data' => $data,
        ], 200);
 }   

}

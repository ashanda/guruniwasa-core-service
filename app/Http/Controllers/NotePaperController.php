<?php

namespace App\Http\Controllers;

use App\Models\NotePaper;
use App\Models\StudentNote;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class NotePaperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

         $request->validate([
            'subject_id' => 'required',
            'teacher_id' => 'required',
        ]);

        try {

            $notes = NotePaper::where('teacher_id', $request->teacher_id)->where('subject_id', $request->subject_id)->get();
            // Return a successful response with the grade and its subjects
            return response()->json([
                'status' => 200,
                'message' => 'teacher_id related note records retrieved successfully',
                'data' => [
                    'notes' => $notes,
                ],
            ], 200);
            
        } catch (Exception $exception) {
            // Handle any exceptions and return an error response
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    public function ClassNotecount(Request $request)
    {

         $request->validate([
            'teacher_id' => 'required',
        ]);
        
        try {

            $count = StudentNote::where('teacher_id', $request->teacher_id)->where('status', 0)->count();
            // Return a successful response with the grade and its subjects
            return response()->json([
                'status' => 200,
                'message' => 'teacher_id related note records count retrieved successfully',
                'data' => [
                    'count' => $count,
                ],
            ], 200);
            
        } catch (Exception $exception) {
            // Handle any exceptions and return an error response
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }


    public function Studentindex(Request $request)
    {

         $request->validate([
            'subject_id' => 'required|integer',
        ]);

        try {

        $notes = NotePaper::where('subject_id', $request->subject_id)
                            ->where(function($query) use ($request) {
                                // If `student_id` is provided, filter by it in `studentUploads`
                                $query->whereHas('studentUploads', function($q) use ($request) {
                                    $q->where('student_id', $request->student_id);
                                })
                                // Also include records where `studentUploads` is empty
                                ->orDoesntHave('studentUploads');
                            })
                            ->with('studentUploads')  // Load `studentUploads` relation, even if empty
                            ->with('subject')
                            ->with('grade')
                            ->get();            // Return a successful response with the grade and its subjects
            return response()->json([
                'status' => 200,
                'message' => 'subject_id related note records retrieved successfully',
                'data' => [
                    'notes' => $notes,
                ],
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function generateShortUniqueId($length = 4)
    {
        return substr(Str::uuid()->toString(), 0, $length);
    }
    public function store(Request $request)
    {
 
        try {
            $request->validate([
                'subject_id' => 'required',
                'teacher_id' => 'required',
            ]);
            $grade = Subject::find($request->subject_id)->first();
            Log::alert($grade->gid);
            $requestData = $request->all(); // Get all request data
            $requestData['grade_id'] = $grade->gid;
            $data = $requestData;
            
            $data['directory'] = 'NP-'.$request->teacher_id.'-'.$this->generateShortUniqueId();
            $note = NotePaper::create($data);

            return response()->json([
                'status' => 200,
                'data' => $note,
                'message' => 'Notes and papers created successfully.',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 400,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NotePaper $notePaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotePaper $notePaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$notePaper)
    {

        try {
           $notePapers = NotePaper::find($notePaper);
           $notePapers->update($request->all());
            
            return response()->json([
                'status' => 200,
                'data' => $notePapers,
                'message' => 'Notes and papers updated successfully.',
            ]);    
        } catch (Exception $exception) {
            return response()->json([  
                'status' => 400, 
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotePaper $notePaper)
    {
        try {
            $notePaper->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Notes and papers deleted successfully.',
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 400,
                'error' => $exception->getMessage(),
            ]);
        }
    }



   public function Noteupload(Request $request)
    {
        try {
            
            $request->validate([
                'student_id' => 'required',
                'teacher_id' => 'required',
                'subject_id' => 'required',
                'grade_id' => 'required',
                'directory' => 'required|string',
            ]);

            // Create a new NotePaper instance
            $note = new StudentNote();
            Log::debug($request->student_id);
            // Assign each field manually
            $note->note_id = $request->note_id;
            $note->student_id = $request->student_id;
            $note->teacher_id = $request->teacher_id;
            $note->subject_id = $request->subject_id;
            $note->grade_id = $request->grade_id;
            $note->directory = $request->directory;
            
            // Save the model instance
            $note->save();

            return response()->json([
                'status' => 200,
                'data' => $note,
                'message' => 'Notes and papers uploaded successfully.',
            ]);
        } catch (Exception $exception) {
            return response()->json([
               'status' => 400,
               'error' => $exception->getMessage(),
           ]);
       }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\NotePaper;
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
            'subject_id' => 'required|integer',
            'teacher_id' => 'required|integer',
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
}

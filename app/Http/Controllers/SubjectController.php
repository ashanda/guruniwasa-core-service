<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
    {
        $request->validate([
            'grade' => 'required|integer', // Validate that 'grade' is required and must be an integer
        ]);

        try {
            // Retrieve the grade with its related subjects
            $grade = Grade::with('subjects')->findOrFail($request->input('grade'));
            
            // Return a successful response with the grade and its subjects
            return response()->json([
                'data' => $grade->subjects, // Assuming 'subjects' is the relationship method in your Grade model
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}

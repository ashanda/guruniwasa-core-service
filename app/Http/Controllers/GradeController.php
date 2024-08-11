<?php
namespace App\Http\Controllers;

use App\Models\Grade;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Grade::all();
            return $this->responseSuccess($data, 'Grades Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If using a view to create a grade, return it here
        // return view('grades.create');
        return $this->responseSuccess([], 'Create form loaded.', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'gname' => 'required',
            ]);

            $grade = Grade::create($request->all());
            return $this->responseSuccess($grade, 'Grade created successfully.', 201);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        try {
            $data = Grade::findOrFail($grade->id);
            return $this->responseSuccess($data, 'Requested Grade.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        try {
            $data = Grade::findOrFail($grade->id);
            // If using a view to edit a grade, return it here
            // return view('grades.edit', compact('grade'));
            return $this->responseSuccess($data, 'Edit form loaded.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        try {
            $request->validate([
                'gname' => 'required',
            ]);

            $grade->update($request->all());
            return $this->responseSuccess($grade, 'Grade updated successfully.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        try {
            $grade->delete();
            return $this->responseSuccess([], 'Grade deleted successfully.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
}

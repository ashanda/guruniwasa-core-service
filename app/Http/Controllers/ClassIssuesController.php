<?php

namespace App\Http\Controllers;
use App\Models\ClassIssues;
use App\Models\Lesson;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;


class ClassIssuesController extends Controller
{
    use ResponseTrait;

public function index(Request $request)
{
    try {
        $month = $request->input('month');
        $data = ClassIssues::with(['lessons.grade', 'lessons.subject'])
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info($data);

        // Modify the data to include gname and sname


        // Return the modified data with responseSuccess
        return $this->responseSuccess($data, 'Class Issues Listed.', 200);

    } catch (Exception $exception) {
        return $this->responseError([], $exception->getMessage(), 400);
    }
}



    public function store(Request $request)

    {

        try {
            $class_issues = new ClassIssues;
            $class_issues->user_id = $request->user_id;
            $class_issues->lesson_id = $request->lesson_id;
            $class_issues->issues = $request->issues;
            $class_issues->save();
            return $this->responseSuccess($class_issues, 'Class Issue created successfully.', 200);
            // return view('notice_board');

        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }



    public function update(Request $request)
    {
    try {
        // Find the class issue by its id
        $classIssuesEdit = ClassIssues::where('id', $request->issue_id)->first();

        // Check if the class issue exists
        if ($classIssuesEdit != null) {
            // Update the class issue fields
            $classIssuesEdit->user_id = $request->user_id;
            $classIssuesEdit->issues = $request->remark;

            // Save the updated class issue
            $classIssuesEdit->save();

            // Return a success response
            return $this->responseSuccess($classIssuesEdit, 'Class Issue updated successfully.', 200);
        } else {
            // Return an error response if the class issue is not found
            return $this->responseError([], 'Class Issue not found.', 404);
        }

    } catch (Exception $exception) {
        // Return an error response in case of an exception
        return $this->responseError([], $exception->getMessage(), 400);
    }
}


    public function destroy(Request $request)
    {
        try {
            $classIssuesDelete = ClassIssues::where('id', $request->class_issues_id)->get()->first();

            if ($classIssuesDelete != null)
            {
                $classIssuesDelete = ClassIssues::where('id', $request->class_issues_id)->delete();
                return $this->responseSuccess([], 'Class Issue deleted successfully.', 200);
            }


        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }






}

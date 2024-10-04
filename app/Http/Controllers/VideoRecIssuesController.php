<?php

namespace App\Http\Controllers;
use App\Models\VideoRecIssues;
use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class VideoRecIssuesController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {
        $month = $request->input('month');
        $data = VideoRecIssues::with(['lessons.grade', 'lessons.subject'])
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();

    

        // Modify the data to include gname and sname


        // Return the modified data with responseSuccess
        return $this->responseSuccess($data, 'Video Recording Issues Listed.', 200);

    } catch (Exception $exception) {
        return $this->responseError([], $exception->getMessage(), 400);
    }

       
    }



    public function store(Request $request)

    {

        try {
            $video_issues = new VideoRecIssues;
            $video_issues->user_id = $request->user_id;
            $video_issues->lesson_id = $request->lesson_id;
            $video_issues->issues = $request->issues;
            $video_issues->save();
            return $this->responseSuccess($video_issues, 'Video Recording Issues created successfully.', 200);
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
        $classIssuesEdit = VideoRecIssues::where('id', $request->issue_id)->first();

        // Check if the class issue exists
        if ($classIssuesEdit != null) {
            // Update the class issue fields
            $classIssuesEdit->user_id = $request->user_id;
            $classIssuesEdit->issues = $request->remark;

            // Save the updated class issue
            $classIssuesEdit->save();

            // Return a success response
            return $this->responseSuccess($classIssuesEdit, 'Video Recording Issue remark updated successfully.', 200);
        } else {
            // Return an error response if the class issue is not found
            return $this->responseError([], 'Video Recording not found.', 404);
        }

    } catch (Exception $exception) {
        // Return an error response in case of an exception
        return $this->responseError([], $exception->getMessage(), 400);
    }


    }


    public function destroy(Request $request)
    {
        try {
            $videoIssuesDelete = VideoRecIssues::where('id', $request->video_issues_id)->get()->first();

            if ($videoIssuesDelete != null)
            {
                $videoIssuesDelete = VideoRecIssues::where('id', $request->video_issues_id)->delete();
                return $this->responseSuccess([], 'Video Recording Issue deleted successfully.', 200);
            }


        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }












}

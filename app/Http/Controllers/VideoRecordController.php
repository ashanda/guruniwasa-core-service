<?php

namespace App\Http\Controllers;

use App\Models\VideoRecord;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class VideoRecordController extends Controller
{
    
    use ResponseTrait;
    public function index(Request $request)
    {

        try {
    $request->validate([
        'grade' => 'required',
        
    ]);
    $month = $request->input('month');

    $videoRecordsQuery = VideoRecord::where('grade_id', $request->input('grade'));
    if ($month) {
            $videoRecordsQuery->whereMonth('created_at', $month);
    }
    $videoRecords = $videoRecordsQuery->with('subject')->get();
    // Map month numbers to month names
       

    // Extract 'sid' values into a separate array
            $sids = $videoRecords->pluck('sid')->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'Grade related video records retrieved successfully',
                'data' => [
                    'video_records' => $videoRecords,
                    'sids' => $sids
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

    public function Teacherindex(Request $request){
        try {
    $request->validate([
        'teacher_id' => 'required',
        
    ]);
    $month = $request->input('month');

    $videoRecordsQuery = VideoRecord::where('teacher_id', $request->input('teacher_id'));
    if ($month) {
            $videoRecordsQuery->whereMonth('created_at', $month);
    }
    $videoRecords = $videoRecordsQuery->with('grade')->with('subject')->get();
    // Map month numbers to month names
       

    // Extract 'sid' values into a separate array
            $sids = $videoRecords->pluck('sid')->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'teacher_id related video records retrieved successfully',
                'data' => [
                    'video_records' => $videoRecords,
                    'sids' => $sids
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

    public function update(Request $request, $id)
    {

        $lesson = VideoRecord::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Video record not found']);
        }


        $lesson->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Video record updated successfully', 'data' => $lesson]);
     }

    public function delete($id)
    {
        $lesson = VideoRecord::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Video record not found']);
        }

        $lesson->delete();

        return response()->json(['status' => 200, 'message' => 'Video record successfully']);
    }
}

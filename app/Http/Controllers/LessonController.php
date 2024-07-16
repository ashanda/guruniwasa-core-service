<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {

        try {
    $request->validate([
        'grade' => 'required',
    ]);

    $liveLessons = Lesson::where('gid', $request->input('grade'))->where('lesson_date', Carbon::today()->toDateString())->get();

    // Extract 'sid' values into a separate array
    $sids = $liveLessons->pluck('sid')->toArray();

    return response()->json([
        'status' => 200,
        'message' => 'Grade related live lessons retrieved successfully',
        'data' => [
            'lessons' => $liveLessons,
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
}

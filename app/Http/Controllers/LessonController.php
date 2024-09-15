<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\ScheduledLesson;
use App\Models\VideoRecord;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class LessonController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {

        try {
            $request->validate([
                'grade' => 'required',
            ]);

    $liveLessons = ScheduledLesson::where('grade_id', $request->input('grade'))->where('lesson_date', Carbon::today()->toDateString())->get();

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


    public function Teacherindex(Request $request)
    {

        try {
            $request->validate([
                'teacher_id' => 'required',
            ]);
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();
        $liveLessons = ScheduledLesson::where('teacher_id', $request->input('teacher_id'))->whereIn('lesson_date', [$today, $tomorrow])->get();

    // Extract 'sid' values into a separate array
            $sids = $liveLessons->pluck('sid')->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'Teacher related live lessons retrieved successfully',
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


public function schedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:teachers,id',
            'grade_id' => 'required',
            'subject_id' => 'required',
            'lesson_title' => 'required|string',
            'lesson_date' => 'required|date',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'zoom_link' => 'nullable|string',
            'password' => 'nullable|string',
            'class_status' => 'nullable|string',
            'special_note' => 'nullable|string',
            'is_recurring' => 'required|boolean',
            'recurrence_type' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $data = $request->all();
        if (!isset($data['status'])) {
            $data['status'] = 'Still Not Scheduled';
        }

        $lesson = ScheduledLesson::create($data);

        return response()->json(['status' => 201, 'message' => 'Lesson scheduled successfully', 'data' => $lesson]);
    }

    public function getSchedule($teacher_id)
    {
        $lessons = ScheduledLesson::where('teacher_id', $teacher_id)
            ->orderBy('lesson_date')
            ->orderBy('start_time')
            ->get();

        return response()->json(['status' => 200, 'data' => $lessons]);
    }

    public function update(Request $request, $id)
    {
        $lesson = ScheduledLesson::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Lesson not found']);
        }

        $validator = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:teachers,id',
            'grade_id' => 'required',
            'subject_id' => 'required',
            'lesson_title' => 'required|string',
            'lesson_date' => 'required|date',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'zoom_link' => 'nullable|string',
            'password' => 'nullable|string',
            'class_status' => 'nullable|string',
            'special_note' => 'nullable|string',
            'is_recurring' => 'required|boolean',
            'recurrence_type' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()]);
        }

        $lesson->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Live lesson updated successfully', 'data' => $lesson]);
     }

    public function delete($id)
    {
        $lesson = ScheduledLesson::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Lesson not found']);
        }

        $lesson->delete();

        return response()->json(['status' => 200, 'message' => 'Lesson deleted successfully']);
    }

    public function autoSchedule()
    {
        $yesterday = Carbon::yesterday()->format('Y-m-d');

        $lessons = ScheduledLesson::where('is_recurring', true)
            ->where('lesson_date', $yesterday)
            ->get();

        foreach ($lessons as $lesson) {
            $nextDate = Carbon::parse($lesson->lesson_date);

            if ($lesson->recurrence_type == 'daily') {
                $nextDate->addDay();
            } elseif ($lesson->recurrence_type == 'weekly') {
                $nextDate->addWeek();
            }

            // Check if a lesson already exists for the next recurrence date
            $existingLesson = ScheduledLesson::where('teacher_id', $lesson->teacher_id)
                ->where('grade_id', $lesson->grade_id)
                ->where('subject_id', $lesson->subject_id)
                ->where('lesson_date', $nextDate->format('Y-m-d'))
                ->where('start_time', $lesson->start_time)
                ->where('end_time', $lesson->end_time)
                ->first();

            // Only create a new lesson if it does not already exist
        if (!$existingLesson) {
            // Create the new lesson
            $newLesson = ScheduledLesson::create([
                'teacher_id' => $lesson->teacher_id,
                'grade_id' => $lesson->grade_id,
                'subject_id' => $lesson->subject_id,
                'lesson_title' => $lesson->lesson_title,
                'lesson_date' => $nextDate->format('Y-m-d'),
                'day_of_week' => $lesson->day_of_week,
                'start_time' => $lesson->start_time,
                'end_time' => $lesson->end_time,
                'zoom_link' => $lesson->zoom_link,
                'password' => $lesson->password,
                'class_status' => $lesson->class_status,
                'special_note' => $lesson->special_note,
                'is_recurring' => $lesson->is_recurring,
                'recurrence_type' => $lesson->recurrence_type,
                'status' => 'Still Not Scheduled', // Set status to Still Not Scheduled
            ]);

            // Create a corresponding video record for the new lesson
            VideoRecord::create([
                'scheduled_lesson_id' => $newLesson->id,
                'teacher_id' => $lesson->teacher_id,
                'grade_id' => $lesson->grade_id,
                'subject_id' => $lesson->subject_id,
                'lesson_title' => $lesson->lesson_title,
                'video_url1' => '', // Set default or leave empty
                'video_url2' => '', // Set default or leave empty
                'video_thumb' => '', // Set default or leave empty
                'status' => 'Still Not Added', // Set status to Still Not Added
            ]);
            }
        }
        return response()->json(['status' => 200, 'message' => 'Lessons auto-scheduled successfully']);
    }



    public function Lessonshow(Request $request)
    {

        try {
            $request->validate([
                'teacher_id' => 'required',
                'lesson_id' => 'required',
            ]);

        $liveLessons = ScheduledLesson::where('id', $request->input('lesson_id'))->where('teacher_id', $request->input('teacher_id'))->get();

    // Extract 'sid' values into a separate array
            $sids = $liveLessons->pluck('sid')->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'Showing lesson id  related live lessons retrieved successfully',
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

    public function Lessonupdate(Request $request)
    {
       try {
           $request->validate([
                'status' => 'required',
                'zoom_link' => 'required',
                'password' => 'required',
                'special_note' => 'nullable',
            ]);

            $data = $request->all();
            $lesson = ScheduledLesson::find($request->input('lesson_id'));
            $lesson->update($data);
            return response()->json([
                'status' => 200,
                'message' => 'Live lesson updated successfully',
                'data' => $lesson
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

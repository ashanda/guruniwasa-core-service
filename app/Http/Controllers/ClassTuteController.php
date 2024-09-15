<?php

namespace App\Http\Controllers;

use App\Models\ClassTute;
use App\Models\Subject;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassTuteController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {

        try {
                $request->validate([
                    'grade' => 'required',
                    
                ]);
                $month = $request->input('month');

                $classTutesQuery = ClassTute::where('grade_id', $request->input('grade'));
                if ($month) {
                        $classTutesQuery->whereMonth('created_at', $month);
                }
                $classTutes = $classTutesQuery->with('ClasstuteSubject')->get();
                // Map month numbers to month names
                
            Log::info($request->input('grade'));
                // Extract 'sid' values into a separate array
                        $sids = $classTutes->pluck('sid')->toArray();

                        return response()->json([
                            'status' => 200,
                            'message' => 'Grade related class tute retrieved successfully',
                            'data' => [
                                'class_tutes' => $classTutes,
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

    $classTutesQuery = ClassTute::where('teacher_id', $request->input('teacher_id'));
    
    $subjectIds = $request->input('subject_id');
    if (!is_array($subjectIds)) {
            return response()->json(['error' => 'subject_id must be an array'], 400);
        }
    
    $classSubjects = Subject::whereIn('id', $subjectIds)
                                ->with('grade')
                                ->get();
    if ($month) {
            $classTutesQuery->whereMonth('created_at', $month);
    }
    $classTutes = $classTutesQuery->with('grade')->with('subject')->get();
    $classTute = ClassTute::where('teacher_id', $request->input('teacher_id'))->with('grade')->with('subject')->get();


     
    // Map month numbers to month names
       

    // Extract 'sid' values into a separate array
            $sids = $classTutes->pluck('sid')->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'teacher_id related class tutes retrieved successfully',
                'data' => [
                    'class_tutes' => $classTute,
                    'class_subjects' => $classSubjects,
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


    public function TeacherStore(Request $request){

        try {
            $request->validate([
                'subject_id' => 'required',
                'teacher_id' => 'required',
                'tute_url' => 'required',

            ]);

            $get_grade = Subject::where('id', $request->subject_id)->first();
            $classTute = ClassTute::create([
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
                'grade_id' => $get_grade->gid,
                'lesson_title' => $request->lesson_title,
                'tute_url' => $request->tute_url,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Class tute created successfully',
                'data' => $classTute
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

        $lesson = ClassTute::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Video record not found']);
        }


        $lesson->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Video record updated successfully', 'data' => $lesson]);
     }

    public function TeacherDestroy($id)
    {
        $lesson = ClassTute::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Class tute not found']);
        }

        $lesson->delete();

        return response()->json(['status' => 200, 'message' => 'Class tute successfully']);
    }

}

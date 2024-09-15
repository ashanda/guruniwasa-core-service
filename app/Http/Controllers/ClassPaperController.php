<?php

namespace App\Http\Controllers;

use App\Models\ClassPaper;
use App\Models\Subject;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassPaperController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {

        try {
                $request->validate([
                    'grade' => 'required',
                    
                ]);
                $month = $request->input('month');

                $classPaperQuery = ClassPaper::where('grade_id', $request->input('grade'));
                if ($month) {
                        $classPaperQuery->whereMonth('created_at', $month);
                }
                $classPapers = $classPaperQuery->with('ClassPaperSubject')->get();
                // Map month numbers to month names
                
         
                // Extract 'sid' values into a separate array
                        $sids = $classPapers->pluck('sid')->toArray();

                        return response()->json([
                            'status' => 200,
                            'message' => 'Grade related class paper retrieved successfully',
                            'data' => [
                                'class_paper' => $classPapers,
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

    $classPaperQuery = ClassPaper::where('teacher_id', $request->input('teacher_id'));
    
    $subjectIds = $request->input('subject_id');
    if (!is_array($subjectIds)) {
            return response()->json(['error' => 'subject_id must be an array'], 400);
        }
    
    $classSubjects = Subject::whereIn('id', $subjectIds)
                                ->with('grade')
                                ->get();
    if ($month) {
            $classPaperQuery->whereMonth('created_at', $month);
    }
    $classPapers = $classPaperQuery->with('grade')->with('subject')->get();
    $classPaper = ClassPaper::where('teacher_id', $request->input('teacher_id'))->with('grade')->with('subject')->get();


     
    // Map month numbers to month names
       

    // Extract 'sid' values into a separate array
            $sids = $classPapers->pluck('sid')->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'teacher_id related class tutes retrieved successfully',
                'data' => [
                    'class_papers' => $classPaper,
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
                'paper_url' => 'required',

            ]);

            $get_grade = Subject::where('id', $request->subject_id)->first();
            $classPaper = ClassPaper::create([
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
                'grade_id' => $get_grade->gid,
                'lesson_title' => $request->lesson_title,
                'paper_url' => $request->paper_url,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Class paper created successfully',
                'data' => $classPaper
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

        $lesson = ClassPaper::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Class paper record not found']);
        }


        $lesson->update($request->all());

        return response()->json(['status' => 200, 'message' => 'Class paper record updated successfully', 'data' => $lesson]);
     }

    public function TeacherDestroy($id)
    {
        $lesson = ClassPaper::find($id);

        if (!$lesson) {
            return response()->json(['status' => 404, 'message' => 'Class paper not found']);
        }

        $lesson->delete();

        return response()->json(['status' => 200, 'message' => 'Class paper successfully']);
    }
}

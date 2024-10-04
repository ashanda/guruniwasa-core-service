<?php

namespace App\Http\Controllers;
use App\Models\TeacherIntro;
use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class TeacherIntroController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        try {


            $data = TeacherIntro::where('teacher_id', $request->teacher_id)->first();
            //return view('notice_board',compact('data'));
            return $this->responseSuccess($data, 'Teacher Intro Listed.', 200);


        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
  
    
    public function store(Request $request)
    {
        try {
            $imageUrl = null;
    
            // Check if an image is uploaded
            if ($request->hasFile('src') && $request->file('src')->isValid()) {
                $destinationPath = "images/uploads/";
                $imageName = date("YmdHis") . '.' . $request->file('src')->getClientOriginalExtension(); 
                 
                $request->file('src')->move($destinationPath, $imageName);
    
               
                $imageUrl = $destinationPath . $imageName;
            }
     
            $teacher_intro = new TeacherIntro;
            $teacher_intro->user_id = $request->user_id;
         
            $teacher_intro->video_link = $request->video_link;
     

           
            $teacher_intro->save();
     
            return $this->responseSuccess($teacher_intro, 'Teacher Intro created successfully.', 200);
            
        } catch (Exception $exception) {
            
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }
    



    public function update(Request $request)
    {
        try {
            // Validate the request inputs
            $validatedData = $request->validate([
                'teacher_id' => 'required',
                'video_url' => 'required',
                // Add any other fields you need to validate
            ]);

            // Use updateOrCreate to either update the existing record or create a new one
            $teacherIntroEdit = TeacherIntro::updateOrCreate(
                // The condition to find the record
                ['teacher_id' => $request->teacher_id],
                // The data to update or create
                [
                    'video_link' => $request->video_url,
                    // Add any other fields you need to update or create
                ]
            );

            return $this->responseSuccess($teacherIntroEdit, 'Teacher Intro updated or created successfully.', 200);

        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
    

    public function destroy(Request $request)
    {
        try {
            $teacherIntroDelete = TeacherIntro::where('id', $request->teacher_intro_id)->get()->first();

            if ($teacherIntroDelete != null)
            {
                $teacherIntroDelete = TeacherIntro::where('id', $request->teacher_intro_id)->delete();
                return $this->responseSuccess([], 'Teacher Intro deleted successfully.', 200);
            }


        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }


}
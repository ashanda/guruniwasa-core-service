<?php

namespace App\Http\Controllers;

use App\Models\IntroVideo;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class IntroVideoController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function studentIntro(){
        try {
            $data = IntroVideo::where('type', 'student')->get();;
            return $this->responseSuccess($data, 'Student Intro Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function teacherIntro(){
        try {
            $data = IntroVideo::where('type', 'teacher')->get();;
            return $this->responseSuccess($data, 'Teacher Intro Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }

        
    }

    public function staffIntro(){
        try {
            $data = IntroVideo::where('type', 'staff')->get();;
            return $this->responseSuccess($data, 'Staff Intro Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }

        
    }

    public function adminIntro(){
          try {
            $data = IntroVideo::where('type', 'admin')->get();;
            return $this->responseSuccess($data, 'Admin Intro Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }

    }
}

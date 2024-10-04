<?php

namespace App\Http\Controllers;
use App\Models\Notice;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class NoticeController extends Controller
{

    use ResponseTrait;

 public function  index(){

    try {

        $data = Notice::orderBy('created_at', 'desc')->get();
        return $this->responseSuccess($data, 'Notice Listed.', 200);
        // return view('notice_board');
    } catch (Exception $exception) {
        return $this->responseError([], $exception->getMessage(), 400);
    }



 }


 public function  indexStudent(){

    try {

        $data = Notice::where('role_type','student')->orderBy('created_at', 'desc')->get();
        return $this->responseSuccess($data, 'Notice Listed.', 200);
         //return view('notice_board',compact('data'));
    } catch (Exception $exception) {
        return $this->responseError([], $exception->getMessage(), 400);
    }



 }




 public function  indexTeacher(){

    try {

        $data = Notice::where('role_type','teacher')->orderBy('created_at', 'desc')->get();
         return $this->responseSuccess($data, 'Notice Listed.', 200);
        //  return view('notice_board',compact('data'));
    } catch (Exception $exception) {
        return $this->responseError([], $exception->getMessage(), 400);
    }



 }


 public function  indexStaff(){

    try {

        $data = Notice::where('role_type','staff')->orderBy('created_at', 'desc')->get();
        return $this->responseSuccess($data, 'Notice Listed.', 200);
        //  return view('notice_board',compact('data'));
    } catch (Exception $exception) {
        return $this->responseError([], $exception->getMessage(), 400);
    }



 }





 public function store(Request $request)

    {

        try {
            $notice = new Notice;
            $notice->user_id = $request->user_id;
            $notice->role_type = $request->role_type;
            $notice->message = $request->message;
            $notice->save();
            return $this->responseSuccess($notice, 'Notice created successfully.', 201);
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


            $noticeEdit = Notice::where('id',$request->notice_id)->get()->first();
            if($noticeEdit != null){
            $noticeEdit->user_id = $request->user_id;
            $noticeEdit->role_type = $request->role_type;
            $noticeEdit->message = $request->message;
        }
            $noticeEdit->save();
            return $this->responseSuccess($noticeEdit, 'Notice updated successfully.', 200);

        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $noticeDelete = Notice::where('id', $request->notice_id)->get()->first();

            if ($noticeDelete != null)
            {
                $noticeDelete = Notice::where('id', $request->notice_id)->delete();
                return $this->responseSuccess([], 'Notice deleted successfully.', 200);
            }


        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }





}

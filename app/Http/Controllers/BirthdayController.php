<?php

namespace App\Http\Controllers;

use App\Models\Birthday;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class BirthdayController extends Controller
{
    use ResponseTrait;

    public function  index(){

        try {

            $data = Birthday::orderBy('created_at', 'desc')->get();
            return $this->responseSuccess($data, 'Birthday Listed.', 200);
            // return view('notice_board',compact('data'));
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }



     }




     public function create()

     {

         try {
            //  $birthday = new Birthday;
            //  $birthday->user_id = $request->user_id;
            //  $birthday->member_id = $request->member_id;
            //  $birthday->wish = $request->wish;
            //  $birthday->save();
            //  return $this->responseSuccess($birthday, 'Birthday created successfully.', 200);
             return view('notice_board');

         } catch (Exception $exception) {
             return response()->json([
                 'error' => $exception->getMessage(),
             ], 400);
         }
     }



     public function store(Request $request)

     {

         try {
             $birthday = new Birthday;
             $birthday->user_id = $request->user_id;
             $birthday->member_id = $request->member_id;
             $birthday->wish = $request->wish;
             $birthday->save();
             return $this->responseSuccess($birthday, 'Birthday created successfully.', 200);


         } catch (Exception $exception) {
             return response()->json([
                 'error' => $exception->getMessage(),
             ], 400);
         }
     }








     public function edit(Request $request )
     {
         try {
             $birthdayEditView = Birthday::where('id',$request->birthday_id)->get()->first();

             // return view('grades.edit', compact('grade'));
             return $this->responseSuccess($birthdayEditView, 'Birthday Edit loaded.', 200);
         } catch (Exception $exception) {
             return $this->responseError([], $exception->getMessage(), 400);
         }
     }




     public function update(Request $request)
     {

         try {


             $birthdayEdit = Birthday::where('id',$request->birthday_id)->get()->first();
             if($birthdayEdit != null){
                $birthdayEdit->user_id = $request->user_id;
                $birthdayEdit->member_id = $request->member_id;
                $birthdayEdit->wish = $request->wish;
         }
             $birthdayEdit->save();
             return $this->responseSuccess($birthdayEdit, 'Birthday updated successfully.', 200);

         } catch (Exception $exception) {
             return $this->responseError([], $exception->getMessage(), 400);
         }
     }


     public function destroy(Request $request)
     {
         try {
             $birthdayDelete = Birthday::where('id', $request->birthday_id)->get()->first();



             if ($birthdayDelete != null)
             {
                 $birthdayDelete = Birthday::where('id', $request->birthday_id)->delete();
                 return $this->responseSuccess([], 'Birthday deleted successfully.', 200);
             }


         } catch (Exception $exception) {
             return $this->responseError([], $exception->getMessage(), 400);
         }
     }


}

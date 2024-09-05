<?php

namespace App\Http\Controllers;

use App\Models\StudentCertificate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentCertificateController extends Controller
{
    public function studentCertificate(Request $request){
        Log::alert($request->all());
         $request->validate([
            'student_id' => 'required',
        ]);
        
        try {

        $certificate = StudentCertificate::where('student_id', $request->student_id)->get();            // Return a successful response with the grade and its subjects
            return response()->json([
                'status' => 200,
                'message' => 'certificate retrieved successfully',
                'data' => [
                    'certificate' => $certificate,
                ],
            ], 200);
            
        } catch (Exception $exception) {
            // Handle any exceptions and return an error response
            return response()->json([
                'error' => $exception->getMessage(),
            ], 400);
        }
    }

    public function studentCertificateUpload(Request $request)
    {
        try {
            
            $request->validate([
                'student_id' => 'required',
                'directory' => 'required|string',
            ]);

            // Create a new NotePaper instance
            $certificate = new StudentCertificate();
            Log::debug($request->student_id);
            // Assign each field manually
            
            $certificate->student_id = $request->student_id;
            $certificate->certificate_link = $request->directory;
            
            // Save the model instance
            $certificate->save();

            return response()->json([
                'status' => 200,
                'data' => $certificate,
                'message' => 'Certificate uploaded successfully.',
            ]);
        } catch (Exception $exception) {
            return response()->json([
               'status' => 400,
               'error' => $exception->getMessage(),
           ]);
       }
    }
}

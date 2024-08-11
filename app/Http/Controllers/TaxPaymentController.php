<?php
namespace App\Http\Controllers;

use App\Models\TaxPayment;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class TaxPaymentController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $taxPayments = TaxPayment::all();
            return $this->responseSuccess($taxPayments, 'Tax Payments Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function create()
    {
        try {
            return $this->responseSuccess([], 'Create Tax Payment Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'job_role' => 'required',
                'tax_amount' => 'required|numeric',
                'payment_date' => 'required|date',
                'document' => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            $data = $request->all();
            if ($request->hasFile('document')) {
                $data['document'] = $request->file('document')->store('documents');
            }

            $taxPayment = TaxPayment::create($data);
            return $this->responseSuccess($taxPayment, 'Tax Payment Created.', 201);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function edit(TaxPayment $taxPayment)
    {
        try {
            return $this->responseSuccess($taxPayment, 'Edit Tax Payment Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function update(Request $request, TaxPayment $taxPayment)
    {
        try {
            $request->validate([
                'name' => 'required',
                'job_role' => 'required',
                'tax_amount' => 'required|numeric',
                'payment_date' => 'required|date',
                'document' => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            $data = $request->all();
            if ($request->hasFile('document')) {
                $data['document'] = $request->file('document')->store('documents');
            }

            $taxPayment->update($data);
            return $this->responseSuccess($taxPayment, 'Tax Payment Updated.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function destroy(TaxPayment $taxPayment)
    {
        try {
            $taxPayment->delete();
            return $this->responseSuccess([], 'Tax Payment Soft Deleted.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function restore($id)
    {
        try {
            $taxPayment = TaxPayment::withTrashed()->findOrFail($id);
            $taxPayment->restore();
            return $this->responseSuccess($taxPayment, 'Tax Payment Restored.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
}

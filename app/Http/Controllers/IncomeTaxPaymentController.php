<?php

namespace App\Http\Controllers;

use App\Models\IncomeTaxPayment;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class IncomeTaxPaymentController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $incomeTaxPayments = IncomeTaxPayment::all();
            return $this->responseSuccess($incomeTaxPayments, 'Income Tax Payments Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function create()
    {
        try {
            return $this->responseSuccess([], 'Create Income Tax Payment Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'payment_details' => 'required',
                'document' => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            $data = $request->all();
            if ($request->hasFile('document')) {
                $data['document'] = $request->file('document')->store('documents');
            }

            $incomeTaxPayment = IncomeTaxPayment::create($data);
            return $this->responseSuccess($incomeTaxPayment, 'Income Tax Payment Created.', 201);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function edit(IncomeTaxPayment $incomeTaxPayment)
    {
        try {
            return $this->responseSuccess($incomeTaxPayment, 'Edit Income Tax Payment Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function update(Request $request, IncomeTaxPayment $incomeTaxPayment)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'payment_details' => 'required',
                'document' => 'nullable|file|mimes:pdf,jpg,png',
            ]);

            $data = $request->all();
            if ($request->hasFile('document')) {
                $data['document'] = $request->file('document')->store('documents');
            }

            $incomeTaxPayment->update($data);
            return $this->responseSuccess($incomeTaxPayment, 'Income Tax Payment Updated.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function destroy(IncomeTaxPayment $incomeTaxPayment)
    {
        try {
            $incomeTaxPayment->delete();
            return $this->responseSuccess([], 'Income Tax Payment Deleted.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function restore($id)
    {
        try {
            $incomeTaxPayment = IncomeTaxPayment::withTrashed()->findOrFail($id);
            $incomeTaxPayment->restore();
            return $this->responseSuccess($incomeTaxPayment, 'Income Tax Payment Restored.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
}

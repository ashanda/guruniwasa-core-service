<?php

namespace App\Http\Controllers;

use App\Models\PaymentCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class PaymentCategoryController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $categories = PaymentCategory::with('children')->whereNull('parent_id')->get();
            return $this->responseSuccess($categories, 'Payment Categories Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function create()
    {
        try {
            $categories = PaymentCategory::whereNull('parent_id')->get();
            return $this->responseSuccess($categories, 'Create Payment Category Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'parent_id' => 'nullable|exists:receipt_categories,id',
            ]);

            $category = PaymentCategory::create($request->all());
            return $this->responseSuccess($category, 'Payment Category Created.', 201);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function show(PaymentCategory $receiptCategory)
    {
        try {
            return $this->responseSuccess($receiptCategory, 'Payment Category Details.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function edit(PaymentCategory $receiptCategory)
    {
        try {
            $categories = PaymentCategory::whereNull('parent_id')->get();
            return $this->responseSuccess(['category' => $receiptCategory, 'categories' => $categories], 'Edit Payment Category Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function update(Request $request, PaymentCategory $receiptCategory)
    {
        try {
            $request->validate([
                'name' => 'required',
                'parent_id' => 'nullable|exists:receipt_categories,id',
            ]);

            $receiptCategory->update($request->all());
            return $this->responseSuccess($receiptCategory, 'Payment Category Updated.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function destroy(PaymentCategory $receiptCategory)
    {
        try {
            $receiptCategory->delete();
            return $this->responseSuccess([], 'Payment Category Soft Deleted.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function restore($id)
    {
        try {
            $receiptCategory = PaymentCategory::withTrashed()->findOrFail($id);
            $receiptCategory->restore();
            return $this->responseSuccess($receiptCategory, 'Payment Category Restored.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
}

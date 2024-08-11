<?php
namespace App\Http\Controllers;

use App\Models\ReceiptCategory;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Exception;

class ReceiptCategoryController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $categories = ReceiptCategory::with('children')->whereNull('parent_id')->get();
            return $this->responseSuccess($categories, 'Receipt Categories Listed.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function create()
    {
        try {
            $categories = ReceiptCategory::whereNull('parent_id')->get();
            return $this->responseSuccess($categories, 'Create Receipt Category Form Data.', 200);
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

            $category = ReceiptCategory::create($request->all());
            return $this->responseSuccess($category, 'Receipt Category Created.', 201);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function show(ReceiptCategory $receiptCategory)
    {
        try {
            return $this->responseSuccess($receiptCategory, 'Receipt Category Details.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function edit(ReceiptCategory $receiptCategory)
    {
        try {
            $categories = ReceiptCategory::whereNull('parent_id')->get();
            return $this->responseSuccess(['category' => $receiptCategory, 'categories' => $categories], 'Edit Receipt Category Form Data.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function update(Request $request, ReceiptCategory $receiptCategory)
    {
        try {
            $request->validate([
                'name' => 'required',
                'parent_id' => 'nullable|exists:receipt_categories,id',
            ]);

            $receiptCategory->update($request->all());
            return $this->responseSuccess($receiptCategory, 'Receipt Category Updated.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function destroy(ReceiptCategory $receiptCategory)
    {
        try {
            $receiptCategory->delete();
            return $this->responseSuccess([], 'Receipt Category Soft Deleted.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function restore($id)
    {
        try {
            $receiptCategory = ReceiptCategory::withTrashed()->findOrFail($id);
            $receiptCategory->restore();
            return $this->responseSuccess($receiptCategory, 'Receipt Category Restored.', 200);
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
}

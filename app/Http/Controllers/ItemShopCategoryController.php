<?php

namespace App\Http\Controllers;

use App\Models\ItemShopCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class ItemShopCategoryController extends Controller
{
    use ResponseTrait;

    public function  index(){

        try {

            $data = ItemShopCategory::orderBy('created_at', 'desc')->get();
            return $this->responseSuccess($data, 'Item Shop Category Listed.', 200);
            // return view('notice_board');
        } catch (Exception $exception) {
            return $this->responseError([], $exception->getMessage(), 400);
        }

    }

     public function store(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'category_name' => 'required',
            ]);

            // Create a new category
            $category = ItemShopCategory::create([
                'name' => $request->category_name,
            ]);

            // Get all categories, ordered by creation date
            $data = ItemShopCategory::orderBy('created_at', 'desc')->get();

            // Return success response
            return $this->responseSuccess($data, 'Item Shop Category Created.', 200);

        } catch (Exception $exception) {
            // Handle any errors
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function update(Request $request)
        {
            try {
                // Validate request data
                $request->validate([
                    'category_name' => 'required|string|max:255',
                ]);

                // Find the category by its ID
                $category = ItemShopCategory::findOrFail($request->category_id);

                // Update the category's name
                $category->update([
                    'name' => $request->category_name,
                ]);

                // Get all categories, ordered by creation date
                $data = ItemShopCategory::orderBy('created_at', 'desc')->get();

                // Return success response
                return $this->responseSuccess($data, 'Item Shop Category Updated.', 200);

            } catch (Exception $exception) {
                // Handle any errors
                return $this->responseError([], $exception->getMessage(), 400);
            }
    }


     public function destroy(Request $request)
    {
        try {
            // Find the category by its ID
            $category = ItemShopCategory::findOrFail($request->category_id);

            // Soft delete the category
            $category->delete();

            // Get all categories, ordered by creation date
            $data = ItemShopCategory::orderBy('created_at', 'desc')->get();

            // Return success response
            return $this->responseSuccess($data, 'Item Shop Category Deleted.', 200);

        } catch (Exception $exception) {
            // Handle any errors
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }


}

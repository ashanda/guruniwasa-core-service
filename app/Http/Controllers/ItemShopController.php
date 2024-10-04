<?php

namespace App\Http\Controllers;

use App\Models\ItemShop;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ItemShopController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            // Get all items in descending order of creation date
            $data = ItemShop::with('category')->orderBy('created_at', 'desc')->get();

            // Return a success response with data
            return $this->responseSuccess($data, 'Item Listed.', 200);
        } catch (Exception $exception) {
            // Return error response on failure
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function store(Request $request)
    {

        Log::info($request->all());
        try {
            // Validate request data
            // $request->validate([
            //     'name' => 'required|string|max:255',
            //     'commission_account' => 'required|string|max:255',
            //     'rate' => 'required|numeric',
            //     'category_id' => 'required|integer',
            //     'commission_id' => 'required|integer',
            //     'code' => 'required|string|max:100|unique:item_shops,item_code',
            //     'price' => 'required|numeric',
            //     'details' => 'nullable|string',
            //     'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //     'weight' => 'required|numeric',
            // ]);



            // Create a new item
            $item = ItemShop::create([
                'name' => $request->name,
                'commission_account' => $request->commission_account_name,
                'rate' => $request->rate,
                'commission_account_id' => $request->commission_account_id,
                'category_id' => $request->category_id,
                'code' => $request->code,
                'price' => $request->price,
                'details' => $request->details,
                'image_path' => $request->file('image_path') ? $request->file('item_image')->store('images', 'public') : null,
                'weight' => $request->weight,
            ]);

            // Return success response
            return $this->responseSuccess($item, 'Item Created.', 200);
        } catch (Exception $exception) {
            // Return error response on failure
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }

    public function update(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'item_id' => 'required|integer|exists:item_shops,id',
                'item_name' => 'required|string|max:255',
                'commission_account' => 'required|string|max:255',
                'commission_rate' => 'required|numeric',
                'commission_id' => 'required|integer',
                'item_code' => 'required|string|max:100|unique:item_shops,item_code,' . $request->item_id,
                'item_price' => 'required|numeric',
                'item_description' => 'nullable|string',
                'item_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'weight' => 'required|numeric',
            ]);

            // Find the item by its ID
            $item = ItemShop::findOrFail($request->item_id);

            // Update the item
            $item->update([
                'item_name' => $request->item_name,
                'commission_account' => $request->commission_account,
                'commission_rate' => $request->commission_rate,
                'commission_id' => $request->commission_id,
                'item_code' => $request->item_code,
                'item_price' => $request->item_price,
                'item_description' => $request->item_description,
                'item_image' => $request->file('item_image') ? $request->file('item_image')->store('images', 'public') : $item->item_image,
                'weight' => $request->weight,
            ]);

            // Return success response
            return $this->responseSuccess($item, 'Item Updated.', 200);
        } catch (Exception $exception) {
            // Return error response on failure
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }


     public function destroy(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'item_id' => 'required|integer|exists:item_shops,id',
            ]);

            // Find the item by its ID
            $item = ItemShop::findOrFail($request->item_id);

            // Soft delete the item
            $item->delete();

            // Return success response
            return $this->responseSuccess([], 'Item Deleted.', 200);
        } catch (Exception $exception) {
            // Return error response on failure
            return $this->responseError([], $exception->getMessage(), 400);
        }
    }
}

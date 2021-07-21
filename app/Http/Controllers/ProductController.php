<?php

namespace App\Http\Controllers;

use App\Models\Product as Model;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\Product as Resource;
use App\Http\Resources\Product\Products as Collection;
use App\Http\Requests\Product\Product as modelRequest;

class ProductController extends Controller
{
    public function index()
    {
        return Collection::collection(Auth::user()->products);
    }

    public function store(modelRequest $request)
    {
        Model::create($this->getInput($request, null));
        return response()->json([
            'message' => 'Product added successfully'
        ], Response::HTTP_CREATED);
    }

    public function show(Model $product)
    {
        if($product->user_id == Auth::id())
            return new Resource($product);
        else
            return response()->json([
                'message' => "Doesn't belong to current user"
            ], Response::HTTP_ACCEPTED);
    }

    public function update(modelRequest $request, Model $product)
    {
        if($product->user_id == Auth::id()) {
            $product->update($this->getInput($request, $product));
            return response()->json([
                'message' => 'Product updated successfully'
            ], Response::HTTP_ACCEPTED);
        }
        else
            return response()->json([
                'message' => "Doesn't belong to current user"
            ], Response::HTTP_ACCEPTED);
    }

    public function destroy(Model $product)
    {
        if($product->user_id == Auth::id()) {
            unlink(storage_path("app/$product->image"));
            $product->delete();
            return response()->json([
                'message' => 'Product deleted successfully'
            ], Response::HTTP_ACCEPTED);
        }
        else
            return response()->json([
                'message' => "Doesn't belong to current user"
            ], Response::HTTP_ACCEPTED);
    }

    private function getInput($request, $modelClass)
    {
        $input = $request->only(['name', 'price', 'description']);

        if(isset($modelClass) ) {
            if($request->image == null)
                $input['image'] = $modelClass->image;
            else {
                $input['image'] = $request->file('image')->store('public');
                unlink(storage_path("app/$modelClass->image"));
            }
        } else {
            $input['image'] = $request->file('image')->store('public');
            $input['user_id'] = Auth::id();
        }

        return  $input;
    }
}

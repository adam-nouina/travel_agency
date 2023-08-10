<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\City;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::with('getCity')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        $product = new Product;
        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->rooms = $validatedData['rooms'];
        $product->city_id = $validatedData['city_id'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('public/elements', $fileName);
            $product->image = asset('storage/elements/' . $fileName);
        }

        // Product::create($request->validated());
        $product->save();
        return response()->json($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product->with('getCity')->findOrFail($product->id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('public/elements', $fileName);
            $product->image = asset('storage/elements/' . $fileName);
            $product->name = $validatedData['name'];
            $product->price = $validatedData['price'];
            $product->description = $validatedData['description'];
            $product->rooms = $validatedData['rooms'];
            $product->city_id = $validatedData['city_id'];

            if($product->save())
                return response()->json(['message'=>"has been added successfully"]);
            }else{
                $product->name = $validatedData['name'];
                $product->price = $validatedData['price'];
                $product->description = $validatedData['description'];
                $product->rooms = $validatedData['rooms'];
                $product->city_id = $validatedData['city_id'];
                $product->save();
                return response()->json(['message'=>"has been added successfully witout image"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json('Product deleted'); 
    }

    public function search (Request $request) {

        $cityId = $request->input('city_id');
        $checkInDate = $request->input('checkIn_Date');
        $checkOutDate = $request->input('checkOut_Date');
        $rooms = $request->input('rooms');

        $reservedProductIds = Reservation::whereBetween('checkIn_date', [$checkInDate, $checkOutDate])
        ->orWhereBetween('checkOut_date', [$checkInDate, $checkOutDate])
        ->pluck('product_id')
        ->toArray();

        $availableProducts = Product::where('city_id', $cityId)
        ->where('rooms', $rooms)
        ->whereNotIn('id', $reservedProductIds)
        ->with('getCity')
        ->get();

        return response()->json($availableProducts);
    }
}
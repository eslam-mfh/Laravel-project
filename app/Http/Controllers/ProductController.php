<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
    public function getProductByQuestions(Request $request)
    {
        $skinType = $request->input('skinType');
        $answer1 = $request->input('answer1');
        $answer2 = $request->input('answer2');

        $products = [
            '1-1-1' => [
                ['name' => 'Niacinamide', 'description' => 'for oily skin'],
                ['name' => 'Salicylic Acid', 'description' => 'for oily skin'],
            ],
            '1-1-2' => [
                ['name' => 'Niacinamide', 'description' => 'for oily skin'],
                ['name' => 'Salicylic Acid', 'description' => 'for oily skin'],
            ],
            '1-1-3' => [
                ['name' => 'Niacinamide', 'description' => 'for oily skin'],
                ['name' => 'Salicylic Acid', 'description' => 'for oily skin'],
            ],
            '1-2-1' => [
                ['name' => 'Niacinamide', 'description' => 'for oily skin'],
                ['name' => 'Salicylic Acid', 'description' => 'for oily skin'],
            ],
            '1-2-2' => [
                ['name' => 'Niacinamide', 'description' => 'for oily skin'],
                ['name' => 'Salicylic Acid', 'description' => 'for oily skin'],
            ],
            '4-1-1' => [
                ['name' => 'Aloe Vera', 'description' => 'for normal skin'],
                ['name' => 'Vitamin C', 'description' => 'for normal skin'],
            ],
            '4-2-1' => [
                ['name' => 'Ceramide', 'description' => 'for normal skin'],
            ],
            '2-4-1' => [
                ['name' => 'Hyaluronic Acid', 'description' => 'for dry skin'],
                ['name' => 'Shea Butter', 'description' => 'for dry skin'],
            ],
            '2-4-2' => [
                ['name' => 'Ceramide', 'description' => 'for dry skin'],
            ],
            '3-1-1' => [
                ['name' => 'Vitamin C', 'description' => 'for combination skin'],
                ['name' => 'Moisturizer', 'description' => 'for combination skin'],
            ],
            '4-3-1' => [
                ['name' => 'Erythromycin', 'description' => 'for acne-prone normal skin'],
                ['name' => 'Benzoyl Peroxide', 'description' => 'for acne-prone normal skin'],
            ],
            '3-3-1' => [
                ['name' => 'Sunscreen', 'description' => 'for acne-prone combination skin'],
                ['name' => 'Panthenol', 'description' => 'for acne-prone combination skin'],
            ],
        ];

        $key = "{$skinType}-{$answer1}-{$answer2}";

        if (array_key_exists($key, $products)) {
            return response()->json($products[$key]);
        } else {
            // إرجاع القيم الافتراضية
            return response()->json([
                ['name' => 'Sunscreen', 'description' => 'for acne-prone combination skin'],
                ['name' => 'Panthenol', 'description' => 'for acne-prone combination skin']
            ]);
        }
    }

}

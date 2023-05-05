<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyProductRequest;
use App\Repositories\Interfaces\BatchRepositoryInterface;
use App\Repositories\Interfaces\BuyRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\StorageRepositoryInterface;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    protected $buy;

    public function __construct(BuyRepositoryInterface $buy)
    {
        $this->buy =  $buy;
    }

    public function buyProducts(BuyProductRequest $request)
    {
        return $this->buy->buyProducts($request);
    }

    public function refundBuyProducts($id)
    {
        return $this->buy->refundBuyProducts($id);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $buy;

    public function __construct(OrderRepositoryInterface $buy)
    {
        $this->buy =  $buy;
    }

    public function sellProduct(OrderRequest $request)
    {
        return $this->buy->sellProducts($request);
    }

    public function refundSellProduct($id)
    {
        return $this->buy->refundSellProducts( $id);
    }
}

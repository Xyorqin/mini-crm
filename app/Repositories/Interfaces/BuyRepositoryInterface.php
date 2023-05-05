<?php

namespace App\Repositories\Interfaces;

interface BuyRepositoryInterface
{
    public function buyProducts($data);
    public function refundBuyProducts($id);
}

<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    public function sellProducts($data);
    public function refundSellProducts($id);
}

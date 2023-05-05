<?php

namespace App\Repositories;

use App\Models\Batch;
use App\Models\BatchProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Models\Product;
use App\Models\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderRepository implements OrderRepositoryInterface
{
    protected $per_page;

    protected
        $order_item,
        $order,
        $batch_product,
        $storage;

    public function __construct(
        BatchProduct $batch_product,
        Storage $storage,
        Order $order,
        OrderItem $order_item,
    ) {
        $this->batch_product    = $batch_product;
        $this->storage          = $storage;
        $this->order_item       = $order_item;
        $this->order            = $order;

        $this->per_page = request('per_page') ? request('per_page') : 10;
    }

    public function sellProducts($request)
    {
        $order_model            = $this->order;
        $order_item_model       = $this->order_item;
        $storage_model          = $this->storage;

        $datetime = $request->get('date', null) ? Carbon::parse($request->get('date', null))->format('Y-m-d') : Carbon::now();

        DB::beginTransaction();
        try {
            $data['order']['client_id'] = $request->get('client_id', null);
            $data['order']['date']      = $datetime;
            $data['order']['refund']    = $request->get('refund', false);

            $order_model->create($data['order']);

            if ($items = $request->get('products', null)) {
                if (is_array($items)) {
                    foreach ($items as $item) {

                        $data['order_item']['product_id']   = $item['product_id'];
                        $data['order_item']['quantity']     = $item['quantity'];
                        $data['order_item']['price']        = $item['price'];
                        $data['order_item']['batch_id']     = $item['batch_id'];
                        $data['order_item']['order_id']     = $order_model->id;

                        $order_item_model->create($data['order_item']);

                        $$storage = $storage_model->firstOrNew(['product_id' => $item['product_id']]);
                        $storage->quantity -= $item['quantity'];
                        $storage->save();
                    }
                }
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json([
            'message' => 'created successfully'
        ], 201);
    }


    public function refundSellProducts($id)
    {
        $order_model            = $this->order;
        $storage_model          = $this->storage;

        DB::beginTransaction();
        try {

            if (!$order = $order_model->find($id)) {
                return response()->json(['error' => 'not found'], 404);
            }
            $order->update(['refund' => true]);

            if ($items = $order->items) {
                foreach ($items as $item) {
                    $storage = $storage_model->firstOrNew(['product_id' => $item['product_id']]);
                    $storage->quantity += $item['quantity'];
                    $storage->save();
                }
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json([], 201);
    }
}

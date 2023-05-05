<?php

namespace App\Repositories;

use App\Models\Batch;
use App\Models\BatchProduct;
use App\Repositories\Interfaces\BuyRepositoryInterface;
use App\Models\Product;
use App\Models\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class BuyRepository implements BuyRepositoryInterface
{
    protected $per_page;

    protected
        $product,
        $batch,
        $batch_product,
        $storage;

    public function __construct(
        Product $product,
        Storage $storage,
        BatchProduct $batch_product,
        Batch $batch
    ) {
        $this->product          = $product;
        $this->batch_product    = $batch_product;
        $this->storage          = $storage;
        $this->batch            = $batch;

        $this->per_page = request('per_page') ? request('per_page') : 10;
    }

    public function buyProducts($request)
    {
        $batch_model            = $this->batch;
        $batch_product_model    = $this->batch_product;
        $storage_model          = $this->storage;
        $product_model          = $this->product;

        $datetime = $request->get('date', null) ? Carbon::parse($request->get('date', null))->format('Y-m-d') : Carbon::now();

        DB::beginTransaction();
        try {
            $data['batch']['provider_id']   =   $request->get('provider_id', null);
            $data['batch']['refund']        =   $request->get('refund', false);
            $data['batch']['date']          =   $datetime;

            $batch = $batch_model->create($data['batch']);

            if ($items = $request->get('products', null)) {
                if (is_array($items)) {
                    foreach ($items as $item) {

                        $data['batch_product']['product_id']    = $item['product_id'];
                        $data['batch_product']['quantity']      = $item['quantity'];
                        $data['batch_product']['price']         = $item['price'];
                        $data['batch_product']['batch_id']      = $batch->id;

                        $batch_product_model->create($data['batch_product']);

                        $storage = $storage_model->firstOrNew(['product_id' => $item['product_id']]);
                        $storage->quantity += $item['quantity'];
                        $storage->save();

                        if ($prod = $product_model->find($item['product_id']))
                            $prod->update([
                                'price' => $item['price']
                            ]);
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


    public function refundBuyProducts($id)
    {
        $batch_model            = $this->batch;
        $storage_model          = $this->storage;

        DB::beginTransaction();
        try {

            if (!$batch = $batch_model->find($id)) {
                return response()->json(['error' => 'not found'], 404);
            }
            $batch->update(['refund' => true]);
            if ($items = $batch->products) {
                foreach ($items as $item) {
                    $storage = $storage_model->firstOrNew([
                        'product_id' => $item['product_id'],
                    ]);
                    $storage->quantity -= $item['quantity'];
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

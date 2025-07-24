<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class SalesController extends Controller
{
    public function purchase(PurchaseRequest $request): JsonResponse
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        // 在庫チェック
        if ($product->stock < $quantity) {
            return response()->json([
                'error' => '在庫が不足しています。',
            ], 400);
        }

        // トランザクション開始
        DB::beginTransaction();

        try {
            // salesテーブルに追加
            $sale = Sale::create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
            ]);

            // productの在庫を更新
            $product->decrement('stock', $quantity);

            // トランザクションコミット
            DB::commit();

            return response()->json([
                'message' => '購入が完了しました。',
                'sale'    => $sale,
            ], 201);

        } catch (\Exception $e) {
            // トランザクションロールバック
            DB::rollBack();

            return response()->json([
                'error' => '購入処理中にエラーが発生しました。',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

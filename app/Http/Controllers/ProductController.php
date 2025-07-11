<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * 商品一覧画面表示
     */
    public function index(Request $request)
    {
        $query = Product::with('company');

        //商品名で検索
        if ($request->filled('keyword')) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        //企業で検索
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        //価格の下限
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        //価格の上限
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        //在庫数の下限
        if ($request->filled('stock_min')) {
            $query->where('stock', '>=', $request->stock_min);
        }

        //在庫数の上限
        if ($request->filled('stock_max')) {
            $query->where('stock', '<=', $request->stock_max);
        }

        // ソート処理
        $sortColumn = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'desc');
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query = Product::with('company');
        if ($sortColumn === 'company_name') {
            $query->select('products.*')
                ->join('companies', 'products.company_id', '=', 'companies.id')
                ->orderBy('companies.company_name', $sortDirection);
        } else {
            $query->orderBy($sortColumn, $sortDirection);
        }


        $products = $query->paginate(10)->appends($request->all());
        $companies = Company::all();

        if ($request->ajax()) {
            return view('products.partials.product_table', compact('products'))->render();
        }

        return view('products.index', compact('products', 'companies'));
    }

    /**
     * 商品新規登録画面表示
     */
    public function create()
    {
        $companies = Company::all();
        return view('products.create', compact('companies'));
    }

    /**
     * 商品新規登録処理
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->company_id = $request->company_id;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;

            if ($request->hasFile('img_path')) {
                $path = $request->file('img_path')->store('public/images');
                $product->img_path = basename($path);
            }

            $product->save();

            DB::commit();

            return redirect()->route('products.create')->with('success', '商品を登録しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('商品登録エラー: ' . $e->getMessage());
            return back()->withInput()->with('error', '商品登録に失敗しました。');
        }
    }

    /**
     * 商品詳細画面表示
     */
    public function show($id)
    {
        $product = Product::with('company')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * 商品編集画面表示
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();
        return view('products.edit', compact('product', 'companies'));
    }

    /**
     * 商品情報更新処理
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        DB::beginTransaction();

        try{
            if ($request->hasFile('img_path')) {
                $image = $request->file('img_path');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
                $validated['img_path'] = $imageName;
            }

            $product->update($validated);

            DB::commit();

            return redirect()->route('products.edit', $product->id)->with('success', '商品を更新しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('商品更新エラー: ' . $e->getMessage());
            return back()->withInput()->with('error', '商品更新に失敗しました。');
        }
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {
            // 画像ファイルの削除
            if ($product->img_path && Storage::exists('public/images/' . $product->img_path)) {
                Storage::delete('public/images/' . $product->img_path);
            }

            $product->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('商品削除エラー: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}

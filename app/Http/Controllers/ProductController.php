<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

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

        $products = $query->paginate(10)->appends($request->all());
        $companies = Company::all();

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
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'img_path' => 'nullable|image|max:2048',
        ]);

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

        return redirect()->route('products.create')->with('success', '商品を登録しました。');
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
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'img_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img_path')) {
            $image = $request->file('img_path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validated['img_path'] = $imageName;
        }

        $product->update($validated);

        return redirect()->route('products.edit', $product->id)->with('success', '商品を更新しました。');
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}

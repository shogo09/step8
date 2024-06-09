<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateRequest;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    
    //商品一覧画面表示
    public function index() {
        $product_model = new Product();
        $company_model = new Company();
        $products = $product_model->index();
        $companies = $company_model->index();
        return view('index', ['products' => $products,'companies' => $companies]);        
    }

    
    //検索
    public function search(Request $request) {
        $search_product = $request->input('keyword');
        $search_company = $request->input('company');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');
        $min_stock = $request->input('min_stock');
        $max_stock = $request->input('max_stock');
        DB::beginTransaction();

        try {
            $product_model = new Product();
            $company_model = new Company();
            $companies = $company_model->index();
            $products = $product_model->getProductSearch($search_product, $search_company, $min_price, $max_price, $min_stock, $max_stock);
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return back();
        }
        return response()->json($products);
    }
    
    // 新規登録画面の表示
    public function create() {

        $company_model = new Company();
        $companies = $company_model->index();
        return view('create', ['companies' => $companies]);
    }

    //商品新規登録
    public function store(CreateRequest $request) {     

        // アップロードされた画像を取得
        $file = $request->file('image');
        // 取得したファイル名で保存
        if ($file) {
            $file_name = $file->getClientOriginalName();
            $file->storeAs('public/images', $file_name);
        } else {
            $file_name = null;
        }
        //トランザクション
        DB::beginTransaction();
        try {
        // 登録処理呼び出し
           $product_model = new Product();
           $product_model->createProduct($request, $file_name);
        DB::commit();
        } catch (\Exception $e) {
        DB::rollback();
        return back();
        }
        //処理が完了したら自画面にリダイレクト
        return redirect()->route('create');
    }

    // 詳細画面
    public function showDetail($id) {   

           $product_model = new Product();
           $product = $product_model->getDetail($id);
           return view ('detail', compact('product'));
    }

    // 編集画面
    public function showEdit($id) {   

          $product_model = new Product();
          $company_model = new Company();
          $product = $product_model->getDetail($id);
          $companies = $company_model->index();
          return view ('edit', ['product' => $product, 'companies' => $companies]);
    }  

    // 更新処理
    public function update(Request $request, $id) {

        $file = $request->file('image');

      if ($file) {
        $file_name = $file->getClientOriginalName();
        $file->storeAs('public/images', $file_name);
      } else {
        $file_name = null;
      }
      //トランザクション開始
      DB::beginTransaction();
      try {
        // 登録処理呼び出し
        $product_model = new Product();
        $product_model->updateProduct($id, $request, $file_name);
        DB::commit();
      } catch (\Exception $e) {
        DB::rollback();
        return back();
      }
        //処理が完了したら自画面にリダイレクト
        return redirect()->route('edit',['id' => $id]);
    }
    
    //削除
    public function destroy($id) {
    DB::beginTransaction();
    
    try {
        Product::find($id)->sales()->delete();
        Product::find($id)->delete();
        DB::commit();
        return response()->json([
            'message' => '商品が削除されました'
        ]);
    } catch (\Exception $e){
        DB::rollback();
        Log::error($e->getMessage());
        return response()->json([
            'message' => '商品の削除に失敗しました'
        ]);
    }
}
    // 購入画面の表示
    public function cart($id) {
        $sale_model = new Sale();
        $product = $sale_model->detail($id);            
        return view('cart',['product' => $product]);       
    }

    public function purchase(Request $request, $id) {
        $quantity = $request->input('quantity');
        DB::beginTransaction();

        try {
            $sale_model = new Sale();
            $message = $sale_model->purchase($quantity, $id);   
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            return back();

        }
        return response()->json([
            'message' => $message
        ]);

 }
}
<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //商品一覧画面表示
    public function index(Request $request) {

        $product_model = new Product();
        $company_model = new Company();
        $companies = $company_model->index();
        
        // 検索キーワードとメーカーがある場合は検索を実行し、結果をビューに渡す
        $keyword = $request->input('keyword');
        $company = $request->input('company');
    
        if (!empty($keyword) || !empty($company)) {
            $search_results = $product_model->search($keyword, $company);
            return view('index', ['search_results' => $search_results, 'companies' => $companies]);
        }
        
        // 検索キーワードとメーカーがない場合は通常の商品一覧を表示する
        $products = $product_model->index();
        return view('index', ['products' => $products, 'companies' => $companies]);
    }

    //検索
    public function search(Request $request) {

        $keyword = $request->input('keyword');
        $company = $request->input('company');
        
        $product_model = new Product();
        $company_model = new Company();
        $companies = $company_model->index(); 
        $search_results = $product_model->search($keyword, $company);

        return view('index', ['search_results' => $search_results, 'companies' => $companies]);
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
      
    // 削除ボタン
    public function delete($id) {

        // トランザクション
        DB::beginTransaction();
        try{
            Product::destroy($id);
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            return back();
        }
        
        //処理が完了したら自画面にリダイレクト
        return redirect()->route('index');
    }
}
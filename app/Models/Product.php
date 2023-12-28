<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model{

    //テーブル名指定
    protected $table = 'products';

    //ホワイトリスト
    protected $fillable = ['company_id','product_name','price','stock','img_path','created_at','updated_at'];

    public $timestamps = true;

    // 一覧画面表示
    public function index() {
    // productsテーブルからデータを取得（クエリビルダ）
    $products = DB::table('products')
        ->join('companies', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->get();
        return $products;
    }

    // 詳細画面表示
    public function getDetail($id) {
    // productsテーブルからデータを取得（クエリビルダ）
    $product = DB::table("products")
        ->join('companies', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->where('products.id', '=', $id)
        ->first();
        return $product;
    }

    //商品登録機能
    public function createProduct($product,$file_name) {
      $img_path = 'images/'.$file_name;

      DB::table('products')->insert([
          'company_id' => $product->company_id,
          'product_name' => $product->product_name,
          'price' => $product->price,
          'stock' => $product->stock,
          'comment' => $product->comment,
          'img_path'  => $img_path,
      ]);
     }


    //編集画面
     public function getEdit($id) {
    // productsテーブルからデータを取得（クエリビルダ）
     $product = DB::table('products')
        ->join('companies', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->where('products.id', '=', $id)
        ->first();
      return $product;
    }
    
    //商品更新
     public function updateProduct($id, $product, $file_name) {

        $img_path = 'images/'.$file_name;

        $product_data = [
          'company_id' => $product->company_id,
          'product_name' => $product->product_name,
          'price' => $product->price,
          'stock' => $product->stock,
          'comment' => $product->comment,
       ];
  
       if ($file_name) {
          $product_data['img_path'] = $img_path;
       }
  
        $product_model = $this->find($id);
        $product_model->update($product_data);
    }

    //商品検索
     public function search($keyword, $company) {
      $query = DB::table('products')
          ->join('companies', 'company_id', '=', 'companies.id')
          ->select('products.*', 'companies.company_name');
  
      if (!empty($keyword)) {
          $query->where('products.product_name', 'like', "%$keyword%");
      }
  
      if (!empty($company)) {
          $query->where('companies.id', $company);
      }
  
      $products = $query->get();
  
      return $products;
    }
 }
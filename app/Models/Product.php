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

    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }

    // 一覧画面表示
    public function index() {
    // productsテーブルからデータを取得（クエリビルダ）
    $products = DB::table('products')
        ->join('companies', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->simplePaginate(10);
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
    public function getProductSearch($searchProduct,$searchCompany,$min_price,$max_price,$min_stock,$max_stock) {
        $products = DB::table('products')
            ->join('companies', 'products.company_id','=', 'companies.id')
            ->select('products.*','companies.company_name');
            
            if($searchProduct) {
                $products->where('product_name', 'like', '%' . $searchProduct . '%');
            }
            if($searchCompany) {
                $products->where('companies.id', $searchCompany);
            }
            if($min_price) {
                $products->where('products.price', '>=',$min_price );
            }
            if($max_price) {
                $products->where('products.price', '<=',$max_price );
            }
            if($min_stock) {
                $products->where('products.stock', '>=',$min_stock );
            }
            if($max_stock) {
                $products->where('products.stock', '<=',$max_stock );
            }
        return $products->paginate(10);
    }

}
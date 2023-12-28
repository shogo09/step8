@extends('layouts.app')

@section('title', '詳細画面')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>詳細画面</h1>
               <table class="table table-striped">
                      <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品画像</th>
                                <th>商品名</th>
                                <th>メーカー名</th>
                                <th>価格</th>
                                <th>在庫数</th>
                                <th>コメント</th>
                            </tr>
                      </thead>
                      <tbody>
                            <tr>
                                <td>{{ $product->id}}</td>
                                <td><img width="100px" src="{{ asset('storage/' . $product->img_path) }}"></td>
                                <td>{{ $product->product_name}}</td>
                                <td>{{ $product->company_name}}</td>
                                <td>{{ $product->price}}</td>
                                <td>{{ $product->stock}}</td>
                                <td>{{ $product->comment}}</td>
                               
                            </tr>
                      </tbody>
               </table>
             <div class="btn-container">
               <!-- 編集ボタン -->
               <div class="edit-btn">
                    <a href="{{ route('edit', $product->id) }}"class="btn btn-success">編集</a>
               </div>

               <!-- 戻るボタン -->
               <div class="back-btn">
                    <a class="btn btn-primary" href="{{ route('index') }}">戻る</a>
               </div>
             </div>
         </div>
   </div>
</div> 
@endsection 
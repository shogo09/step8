@extends('layouts.app')

@section('title','商品一覧')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>商品一覧画面</h1>

            <!-- エラーがある場合に表示される -->
            @if (session('err_msg'))
            <p class="text-danger">{{ session('err_msg') }}</p>
            @endif

            <!-- 検索フォーム -->
            <div class="row justify-content-between pt-4 mb-4">
                <div class="col-md-12">
                    <form class="form-inline" action="{{ route('search') }}" method="GET">
                        @csrf
                        <div class="form-group mr-2">
                            <input type="text" name="keyword" class="form-control" placeholder="キーワード検索" id="Keyword">
                        </div>

                        <!-- カテゴリー -->
                        <div class="form-group mr-2">
                            <select class="form-control" id="Company_id" name="company">
                                <option value="">メーカー名</option>
                                @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label">価格</label>
                              <input class="min_price form-control" type="text" name="min_price" placeholder="下限価格"> 円 〜
                              <input class="max_price form-control" type="text" name="max_price" placeholder="上限価格"> 円
                        </div>

                        <div class="form-group">
                            <label class="label">在庫数</label>
                              <input class="min_stock form-control" type="text" name="min_stock" placeholder="下限在庫数"> 個 〜
                              <input class="max_stock form-control" type="text" name="max_stock" placeholder="上限在庫数"> 個
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-secondary" id="Search-btn" data-url="{{ route('search') }}">検索</button>
                        </div>
                    </form>
                </div>
            </div>

    

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" class="table-header">ID</th>
                    <th scope="col" class="table-header">商品画像</th>
                    <th scope="col" class="table-header">商品名</th>
                    <th scope="col" class="table-header">価格</th>
                    <th scope="col" class="table-header">在庫数</th>
                    <th scope="col" class="table-header">メーカー名</th>

                    <!-- 新規登録ボタン -->
                    <th>
                        <div class="container">
                            <button onclick="location.href='./create'" class="btn btn-success">新規登録</button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody id="productList">
                <h2>検索結果</h2>
                @foreach($products as $product)
                  <tr class="table-row" data-id="{{ $product->id }}">
                    <td class="table-data">{{ $product->id }}</td>
                    <td class="table-data"><img width="100px" src="{{ asset('storage/' . $product->img_path) }}"></td>
                    <td class="table-data">{{ $product->product_name }}</td>
                    <td class="table-data">{{ $product->price }}</td>
                    <td class="table-data">{{ $product->stock }}</td>
                    <td class="table-data">{{ $product->company_name }}</td>
                    <td class="table-data"><a href="{{ route('detail', $product->id) }}" class="btn btn-primary btn-sm">詳細</a></td>
                    <td class="table-data">
                         <form method="POST" action="{{ route('delete', $product->id) }}" class="delete-form">
                         @csrf
                         @method('DELETE')
                          <button data-id="{{ $product->id }}" type="submit" data-url="{{ route('delete', $product->id) }}" class="btn btn-danger btn-sm btn-delete">削除</button>
                        </form>
                    </td>
                    <td class="table-data">
                       <a href="{{ route('cart', ['id' => $product->id]) }}" class="btn btn-warning btn-sm">購入</a>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </table>

        <!-- ページネーションリンク -->
       {{ $products->links() }}
    </div>
</div>
</div>
@endsection
@extends('layouts.app')

@section('title', '商品一覧')

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
                                <input type="text" name="keyword" class="form-control" placeholder="キーワード検索" id="txtKeyword">
                            </div>

                            <!-- カテゴリー -->
                            <div class="form-group mr-2">
                                <select class="form-control" id="drpCompanyId" name="company">
                                    <option value="">メーカー名</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-secondary" id="btnSearch">検索</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 商品テーブル -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー名</th>

                            <!-- 新規登録ボタン -->
                            <th>
                                <div class="container">
                                    <button onclick="location.href='./create'" class="btn btn-success">新規登録</button>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="productList">
                        @forelse ($search_results ?? $products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td><img width="200px" src="{{ asset("storage/$product->img_path") }}" /></td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->company_name }}</td>
                                <td><a href="{{ route('detail', $product->id) }}" class="btn btn-primary btn-sm">詳細</a></td>
                                <td>
                                    <form method="POST" action="{{ route('delete', $product->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('削除しますか？');">削除</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">検索結果がありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
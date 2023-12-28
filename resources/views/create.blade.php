@extends('layouts.app')

@section('title', '登録画面')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
        <h1>商品登録</h1>
        <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
        @csrf

            <!-- 商品名登録 -->
            <div class="form-container pt-4">
                <div class="form-group">
                    <label for="product_name">商品名<span>*</span></label>
                    <input type="product_name" class="form-control" id="txtProductName"  name="product_name"  value="{{old('product_name')}}">
                    @if ($errors->has('product_name'))
                    <div class="text-danger">
                            <p>{{ $errors->first('product_name') }}</p>
                    @endif
                    </div>
                </div>

                <!-- メーカ名 -->
                <div class="form-group pt-2">
                    <label for="company_id">{{ __('メーカー名') }}<span>*</span><span class="badge badge-danger ml-2"></span></label>
                    <select class="form-control" id="drpCompanyId" name="company_id">
                        <option value="">     </option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                    </select>
                    @if ($errors->has('company_id'))
                    <div class="text-danger">
                            <p>{{ $errors->first('company_id') }}</p>
                    @endif
                </div>

                <!-- 価格登録 -->
                <div class="form-group pt-2">
                    <label for="price">価格<span>*</span></label>
                    <input type="price" class="form-control" id="numPrice" name="price" value="{{old('price')}}">
                    @if ($errors->has('price'))
                      <div class="text-danger">
                            <p>{{ $errors->first('price') }}</p>
                      </div>
                    @endif
                </div>

                <!-- 在庫数登録 -->
                <div class="form-group pt-2">
                    <label for="stock">在庫数<span>*</span></label>
                    <input type="stock" class="form-control" id="numStock" name="stock" value="{{old('stock')}}">
                    @if ($errors->has('stock'))
                      <div class="text-danger">
                            <p>{{ $errors->first('stock') }}</p>
                      </div>
                    @endif
                </div>

                <!-- コメント -->
                <div class="form-group pt-2">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="areaComment" name="comment"></textarea>{{old('comment')}}</textarea>
                    @if ($errors->has('comment'))
                      <div class="text-danger">
                            {{ $errors->first('comment') }}
                      </div>
                    @endif
                    
                </div>

                <!-- 画像登録 -->
                <div class="form-group pt-4">
                @csrf
                     <label for="image">画像</label> 
                     <input type="file" name="image">
                </div>
                <!-- 登録ボタン -->
                <div class="btn-container">
                    <div class="create-btn">
                       <button type="submit" class="btn btn-success">登録</button>
                    </div>
                <!-- 戻るボタン -->
                    <div class="back-btn">
                       <a class="btn btn-primary" href="{{ route('index') }}">戻る</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
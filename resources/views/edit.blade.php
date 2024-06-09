@extends('layouts.app')

@section('title', '編集画面')

@section('content')
<div class="container">
   <div class="row justify-content-center">
        <div class="col-md-12 col-md-offset-2">
           <h1>商品編集画面</h1>
             <form method="POST" action="{{ route('update', ['id' => $product->id ]) }}" onSubmit="checkSubmit()" enctype="multipart/form-data">
                @csrf
                @method('PUT')

               <div class="edit-title pt-4">
                   <h5>ID.{{ $product->id}}</h5>
               </div>

               <div class="form-edit">
               <!-- 商品名 -->
                   <div class="form-name pt-2">
                        <label for="company_id">{{ __('商品名') }}<span>*</span></label>
                             <input type="text" class="form-control" name="product_name" id="txtProductName" value="{{ $product->product_name}}">
                             @if ($errors->has('product_name'))
                             <div class="text-danger">
                                <p>{{ $errors->first('product_name') }}</p>
                             </div>
                             @endif
                                   
                   
               <!-- メーカー名-->
                   <div class="form-company pt-2">
                        <label for="company_name">メーカー名<span>*</span></label>
                            <select name="company_id" id="drpCompany" class="form-control">
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" @if($company->id == $product->company_id) selected @endif>{{ $company->company_name }}</option>
                                    @endforeach
                            </select>
                                    @if ($errors->has('company_id'))
                                    <span class="text-danger" role="alert">
                                    {{ $errors->first('company_id') }}
                                    </span>
                                    @endif
                   </div>
              <!-- 価格登録 -->
                   <div class="form-price pt-2">
                        <label for="price">価格<span>*</span></label>
                            <input type="price" class="form-control" id="numPrice" name="price" placeholder="Price" value="{{ $product->price}}">
                                    @if ($errors->has('price'))
                                    <div class="text-danger">
                                        <p>{{ $errors->first('price') }}</p>
                                    @endif
                                    </div>
                   </div>
              <!-- 在庫数登録 -->
                   <div class="form-stock pt-2">
                       <label for="stock">在庫数<span>*</span></label>
                           <input type="stock" class="form-control" id="numStock" name="stock" placeholder="Stock" value="{{ $product->stock}}">
                                   @if ($errors->has('stock'))
                                  <div class="text-danger">
                                       <p>{{ $errors->first('stock') }}</p>
                                  </div>
                                   @endif
                   </div>
              <!-- コメント -->
                   <div class="form-comment pt-2">
                       <label for="comment">コメント</label>
                            <textarea class="form-control" id="areaComment" name="comment">{{ $product->comment }}</textarea>
                                    @if ($errors->has('comment'))
                                  <div class="text-danger">
                                      {{ $errors->first('comment') }}
                                  </div>
                                    @endif
                   </div>
               <!-- 画像　-->
               <div class="form-img pt-2">
                   <label for="img">商品画像</label>
                          @csrf
                          <input type="file" name="image">
                                  @if ($product->img_path)
                                  <!-- DBから呼び出した画像が存在する場合 -->
                                  <img width="100px" src="{{ asset('storage/' . $product->img_path) }}" alt="商品画像">
                                  @else
                                  <!-- DBから呼び出した画像が存在しない場合 -->
                                     @if (!old('image'))
                                      <p>画像が登録されていません</p>
                                     @endif
                                  @endif
               </div>

        </div>

               <!-- 更新ボタン -->
            <div class="btn-container">
                     <div class="update-btn">
                           <button type="submit" class="btn btn-info">更新</button>
                     </div>
                     <div class="back-btn">
                           <a class="btn btn-primary" href="{{ route('detail', $product->id) }}">戻る</a>
                     </div>
            </div>
          </form>
       </div>
    </div>
</div>
@endsection
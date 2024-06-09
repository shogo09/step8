@extends('layouts.app')

@section('title', '登録画面')

@section('content')
<div class="row mx-auto">
    <div class="col-md-8">
        <h2>商品登録</h2>
        <form method="POST" action="{{ route('store') }}" onSubmit="checkSubmit()" enctype="multipart/form-data">
        @csrf

            <!-- 商品名登録 -->
            <div class=form-container>
                <div class="form-group">
                    <label for="product_name">商品名*</label>
                    <input type="product_name" class="form-control" id="product_name"  name="product_name"  value="{{old('product_name')}}">
                    @if ($errors->has('product_name'))
                    <div class="text-danger">
                            <p>{{ $errors->first('product_name') }}</p>
                    @endif
                    </div>
            </div>

                <!--メーカ名-->
            <div class="form-group">
                    <label for="company_id">{{ __('メーカー名*') }}<span class="badge badge-danger ml-2"></span></label>
                    <select class="form-control" id="company_id" name="company_id">
                        <option value="">     </option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                    </select>
            </div>

                <!-- 価格登録 -->
            <div class="form-group">
                    <label for="price">価格*</label>
                    <input type="price" class="form-control" id="price" name="price" value="{{old('price')}}">
                    @if ($errors->has('price'))
                      <div class="text-danger">
                            <p>{{ $errors->first('price') }}</p>
                    @endif
                      </div>
            </div>

                <!-- 在庫数登録 -->
            <div class="form-group">
                    <label for="stock">在庫数*</label>
                    <input type="stock" class="form-control" id="stock" name="stock" value="{{old('stock')}}">
                    @if ($errors->has('stock'))
                      <div class="text-danger">
                            <p>{{ $errors->first('stock') }}</p>
                      </div>
                    @endif
            </div>

                <!-- コメント -->
            <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment"></textarea>{{old('comment')}}</textarea>
                    @if ($errors->has('comment'))
                      <div class="text-danger">
                            {{ $errors->first('comment') }}
                      </div>
                    @endif
            </div>

                <!-- 画像登録 -->
                <div class="form-group">
                @csrf
                     <label for="image">画像</label> 
                     <input type="file" name="image">
                </div>

                <!-- 登録ボタン -->
            <div class="create-btn">
                <div class="mt-5">
                    <button type="submit" class="btn btn-danger btn-sm">登録</button>
                </div>
            </div>
                <!-- 戻るボタン -->
            <div class="createback">
                 <input class="btn btn-primary btn-sm" type="button" onclick="history.back(-1)" value="戻る">
            </div>
        </form>
    </div>
</div>



<!-- 確認表示 -->
<script>
function checkSubmit(){
    if(window.confirm('登録してよろしいですか？')){
        return true;
    } else {
        window.alert('キャンセルされました');
        return false;
    }
}
</script>
@endsection
<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
     
    //use HasFactory;
    // テーブル名
    protected $table = 'companies';

    // ホワイトリスト
    protected $fillable =['company_name','street_address', 'representative_name',];

    // 一覧画面表示
    public function index() {
        // Companyテーブルからデータを取得
        $companies = DB::table('companies')
        ->get();

        return $companies;
    }
}
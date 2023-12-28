<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Authenticatableで要求されるメソッド
     public function getAuthIdentifierName() {
      return 'id'; // ユーザーの識別子となるカラム名を返す
    }

     public function getAuthIdentifier() {
      return $this->getKey(); // ユーザーの識別子の値を返す（通常はidカラムの値）
    }

     public function getAuthPassword() {
      return $this->password; // ユーザーのパスワードを返す
    }

     public function getRememberToken() {
      return $this->remember_token; // remember_tokenカラムの値を返す
    }

     public function setRememberToken($value) {
      $this->remember_token = $value; // remember_tokenカラムに値を設定する
    }

     public function getRememberTokenName() {
      return 'remember_token'; // remember_tokenカラムの名前を返す
    }
}
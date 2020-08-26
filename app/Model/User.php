<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //1.关联的数据表
    public $table = 'user';
    //2.主键
    public $primaryKey = 'user_id';
    //3.允许批量操作
    //public $fillable = ['user_name','user_pass',等等];
    //不允许批量操作的 直接空的话 就是都可以
    public $guarded = [];
    //4.是否维护哪两个字段
    public $timestamps = false;
}

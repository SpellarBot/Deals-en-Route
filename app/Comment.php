<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    public $table = 'comment';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $primaryKey = 'comment_id';
    protected $fillable = [
        'comment_id', 'created_at', 'updated_at', 'comment_desc', 'activity_id'
    ];

    public function user() {
        return $this->hasOne('App\UserDetail', 'user_id', 'created_by');
    }

}

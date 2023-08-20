<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        
       'uuid' , 'content' ,'is_true','question_id'
    ];
    protected $casts = [
        'id' => 'integer',
        'question_id'=>'integer',
        'is_true'=>'boolean'
       ];
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

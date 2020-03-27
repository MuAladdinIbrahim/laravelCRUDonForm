<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Post extends Model
{
    use Sluggable;

    //fillable to enable update or insert in these columns
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user()
    {
        //every Post belongs to a user (M:1)
        return $this->belongsTo('App\User');
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}

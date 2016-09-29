<?php

namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class Like extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $collection = 'laravellikecomment_likes';

    /**
	 * Fillable array
     */
    protected $fillable = ['user_id', 'item_id', 'vote'];
}

<?php

namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

class TotalLike extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $collection = 'laravellikecomment_total_likes';

    /**
	 * Fillable array
     */
    protected $fillable = [];
}

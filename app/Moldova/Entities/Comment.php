<?php

namespace App\Moldova\Entities;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Comment
 * @package App\Moldova\Entities
 */

class Comment extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $collection = 'laravellikecomment_comments';

    /**
	 * Fillable array
     */
    protected $fillable = ['user_id', 'parent_id', 'item_id', 'comment','status'];
}

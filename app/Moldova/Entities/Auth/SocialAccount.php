<?php
namespace App\Moldova\Entities\Auth;

use App\User as AppUser;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class SocialAccount
 * @package App\Moldova\Entities\Auth
 */
class SocialAccount extends Model
{
    /**
     * @var string
     */
    protected $collection = 'social_accounts';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    /**
     * Social account belongs to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(AppUser::class);
    }
}

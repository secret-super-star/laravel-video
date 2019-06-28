<?php

namespace App\Models\Auth\User;

use App\Models\Auth\User\Traits\Attributes\UserAttributes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\User\Traits\Ables\Rolable;
use App\Models\Auth\User\Traits\Scopes\UserScopes;
use App\Models\Auth\User\Traits\Relations\UserRelations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Input;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\Auth\User\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $active
 * @property string $confirmation_code
 * @property bool $confirmed
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read mixed $avatar
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\User\SocialAccount[] $providers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Role\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereConfirmationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereConfirmed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereRole($role)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Auth\User\User sortable($defaultSortParameters = null)
 */
class User extends Authenticatable
{
    use Rolable,
        UserAttributes,
        UserScopes,
        UserRelations,
	      HasApiTokens,
        Notifiable,
//        SoftDeletes,
        Sortable;

    public $sortable = ['name', 'email', 'created_at', 'updated_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'active', 'confirmation_code', 'confirmed', 'image', 'banner', 'country'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
	
	/**
	 * The roles that belongs to user
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles()
	{
		return $this->belongsToMany('App\Models\Auth\Role\Role', 'users_roles', 'user_id', 'role_id');
	}
	
	/**
	 * @param $roleName
	 * @return bool
	 */
	public function hasRole($roleName)
	{
		foreach ($this->roles()->get() as $role) {
			if ($role->name == $roleName) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	public function updateUser($request)
	{
		try {
			$input = ([
				'name' => $request['name'] ? $request['name'] : NULL,
				'banner' => $request['bannerName'] ? URL::to('/') . '/uploads/' . $request['bannerName'] : NULL,
				'image' => $request['avatarName'] ? URL::to('/') . '/uploads/' . $request['avatarName'] : NULL,
				'password' => $request['pwd'] ? bcrypt($request['pwd']) : NULL,
				'country' => $request['country'] ? $request['country'] : NULL,
			]);
			$input = array_filter($input, 'strlen');
			$data =$this->where('id', '=', Auth::user()->id)->update($input);
			
			if ($request['avatarName']) {
				$this->socialAccount = new SocialAccount();
				($this->socialAccount->where('user_id', '=', Auth::user()->id)->update([
					'avatar' => URL::to('/') . '/uploads/' . $request['avatarName']
				]));
			}
			return collect([
				'status' => 'success',
				'data' => $data
			]);
		} catch (\Exception $e) {
			return collect([
				'status' => 'failure',
				'message' => $e->getMessage()
			]);
		}
	}
	
	public function likedVideos()
	{
		return $this->hasMany('App\Models\UsersLikedVideos', 'user_id', 'id');
	}
	
	public function getUserDetailByName($name)
	{
		return $this->with('likedVideos')->where('name', '=', $name)->first();
	}
	
}

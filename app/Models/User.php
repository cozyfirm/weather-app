<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Core\Country;
use App\Models\Users\History\SearchHistory;
use App\Traits\Common\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(string $string, string $string1, int $int)
 * @method static create(array $except)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, CommonTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'api_token',
        'role',
        'prefix',
        'phone',
        'birth_date',
        'address',
        'city',
        'country',
        'about',
        'photo_uri',
        'instagram',
        'facebook',
        'twitter',
        'linkedin',
        'web'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function photoUri(){
        return isset($this->photo_uri) ? $this->photo_uri : 'silhouette.png';
    }
    public function birthDate(): string {
        return Carbon::parse(isset($this->birth_date) ? $this->birth_date : date('Y-m-d'))->format('d.m.Y');
    }
    public function countryRel(): HasOne{
        return $this->hasOne(Country::class, 'id', 'country');
    }
}

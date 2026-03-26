<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_number',
        'first_name',
        'last_name',
        'phone',
        'email',
        'national_id',
        'address'
    ];

    public function member()
{
    return $this->belongTo(Member::class);
}

}

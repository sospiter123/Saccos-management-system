<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public function repayments()
{
    return $this->hasMany(Repayment::class);
}

public function loans()
{
    return $this->hasMany(Loan::class);
}
}

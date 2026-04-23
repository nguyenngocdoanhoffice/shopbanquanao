<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['code', 'discount_percent', 'discount_amount', 'expired_at', 'is_active', 'apply_all'])]
class Coupon extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
            'is_active' => 'boolean',
            'apply_all' => 'boolean',
        ];
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}

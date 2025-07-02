<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatLock extends Model
{
    use HasFactory;

    protected $table = 'seat_locks';

    // الحقول اللي ممكن تعبئتها بشكل جماعي
    protected $fillable = [
        'trip_id',
        'seat_number',
        'user_id',
        'locked_at',
    ];

    // تعطيل التوقيتات الافتراضية (created_at و updated_at) لو ما تحتاجها
    public $timestamps = false;

    // لو حبيت تحوّل locked_at تلقائيًا إلى كائن Carbon
    protected $dates = [
        'locked_at',
    ];

    // العلاقات (مثال: قفل الكرسي مرتبط برحلة)
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // علاقة مع المستخدم اللي قفل الكرسي
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



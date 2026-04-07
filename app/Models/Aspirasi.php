<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasi';

    protected $fillable = [
        'user_id',
        'kategori',
        'judul',
        'deskripsi',
        'status',
        'feedback',
        'tanggal_submit',
        'tanggal_penyelesaian',
        'progres',
    ];

    protected $casts = [
        'tanggal_submit' => 'datetime',
        'tanggal_penyelesaian' => 'datetime',
        'progres' => 'integer',
    ];

    /**
     * Relasi ke User (pembuat aspirasi)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: status sedang diproses
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope: status selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}

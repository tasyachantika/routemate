<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'subject',
        'description',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat satu aktivitas admin. Kegagalan mencatat log tidak boleh
     * menggagalkan aksi admin itu sendiri, jadi error ditelan di sini.
     */
    public static function record(string $action, string $subject, ?string $description = null): void
    {
        try {
            static::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'subject' => $subject,
                'description' => $description,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {
            // Abaikan: log aktivitas bersifat tambahan (audit), bukan fungsi inti.
        }
    }
}

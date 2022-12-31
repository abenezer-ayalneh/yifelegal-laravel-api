<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "request_id",
        "attribute",
        "value",
        "created_by",
        "updated_by",
        "created_at",
        "updated_at",
        "deleted_by",
        "deleted_at",
    ];

    /*
     * The parent request
     */
    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }
}

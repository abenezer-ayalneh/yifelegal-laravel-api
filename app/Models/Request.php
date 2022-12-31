<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        "is_request_for_others",
        "requested_for",
        "requested_for_phone_number",
        "created_by",
        "updated_by",
        "deleted_by",
        "deleted_at",
        "created_at",
        "updated_at",
    ];

    /*
     * Relationship with request_detail table
     */
    public function detail(): HasMany
    {
        return $this->hasMany(RequestDetail::class, "request_id");
    }
}

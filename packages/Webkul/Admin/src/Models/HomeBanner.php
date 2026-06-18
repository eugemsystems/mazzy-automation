<?php

namespace Webkul\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeBanner extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'button_text', 'button_url', 'image_path', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }

        return '';
    }
}

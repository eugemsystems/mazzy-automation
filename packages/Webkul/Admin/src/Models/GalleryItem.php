<?php

namespace Webkul\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    protected $fillable = [
        'type', 'title', 'file_path', 'url', 'display_on', 'section', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getDisplayUrlAttribute(): string
    {
        if ($this->file_path) {
            return Storage::disk('public')->url($this->file_path);
        }

        return $this->url ?? '';
    }
}

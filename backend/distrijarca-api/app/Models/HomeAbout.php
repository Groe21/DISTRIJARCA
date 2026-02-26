<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomeAbout extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'title_before',
        'title_highlight',
        'title_after',
        'paragraph_1',
        'paragraph_2',
        'stat_1_value',
        'stat_1_label',
        'stat_2_value',
        'stat_2_label',
        'stat_3_value',
        'stat_3_label',
        'image',
        'image_alt',
        'badge_text',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        return 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=800';
    }
}

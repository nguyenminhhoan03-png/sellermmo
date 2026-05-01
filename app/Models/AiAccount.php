<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAccount extends Model
{
    use HasFactory, HasSlug;

    protected $table      = 'ai_accounts';

    protected string $slugType   = 'ai';
    protected string $slugField  = 'name';
    protected string $slugPrefix = '/ai-account';

    public function getSlugUrlAttribute(): string
    {
        $slug = $this->slug;
        if (!$slug) {
            $slug = \App\Models\Slug::of($this->slugType, $this->getKey()) ?? (string) $this->getKey();
        }

        return url($this->slugPrefix . '/' . $slug);
    }

    protected $fillable = [
        'name', 'image', 'description', 'account_info', 'status', 'category_id',
    ];

    public function variant()
    {
        return $this->hasMany(AiAccountVariant::class, 'account_id', 'id');
    }
}

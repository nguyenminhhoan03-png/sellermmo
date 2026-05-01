<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Slug extends Model
{
    protected $table    = 'slugs';
    protected $fillable = ['slug', 'slug_type', 'slug_id'];

    // ── Tìm bản ghi theo slug + type ─────────────────────────────────────────
    public static function find(string $slug, string $type): ?self
    {
        return static::where('slug', $slug)->where('slug_type', $type)->first();
    }

    // ── Tạo hoặc cập nhật slug cho 1 bản ghi ─────────────────────────────────
    public static function sync(string $type, int $id, string $name): self
    {
        $existing = static::where('slug_type', $type)->where('slug_id', $id)->first();

        $slug = static::makeUnique($name, $id, $type, $existing?->slug);

        if ($existing) {
            // Chỉ đổi nếu tên thay đổi
            if ($existing->slug !== $slug) {
                $existing->update(['slug' => $slug]);
            }
            return $existing->fresh();
        }

        return static::create([
            'slug'      => $slug,
            'slug_type' => $type,
            'slug_id'   => $id,
        ]);
    }

    // ── Xóa slug khi xóa bản ghi ─────────────────────────────────────────────
    public static function remove(string $type, int $id): void
    {
        static::where('slug_type', $type)->where('slug_id', $id)->delete();
    }

    // ── Lấy slug URL của 1 bản ghi ────────────────────────────────────────────
    public static function of(string $type, int $id): ?string
    {
        return static::where('slug_type', $type)->where('slug_id', $id)->value('slug');
    }

    // ── Tạo slug duy nhất ─────────────────────────────────────────────────────
    private static function makeUnique(string $name, int $id, string $type, ?string $current = null): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'item';
        }

        if ($current && Str::slug($current) === $base) {
            return $current;
        }

        $candidate = $base;
        $exists = static::where('slug', $candidate)
            ->where(function ($q) use ($type, $id) {
                $q->where('slug_type', '!=', $type)
                  ->orWhere('slug_id', '!=', $id);
            })
            ->exists();

        if (!$exists) {
            return $candidate;
        }

        $suffix = 2;
        do {
            $candidate = $base . '-' . $suffix;
            $exists = static::where('slug', $candidate)
                ->where(function ($q) use ($type, $id) {
                    $q->where('slug_type', '!=', $type)
                      ->orWhere('slug_id', '!=', $id);
                })
                ->exists();
            $suffix++;
        } while ($exists);

        return $candidate;
    }
}

<?php

namespace App\Traits;

use App\Models\Slug;

/**
 * Gắn trait này vào bất kỳ Eloquent model nào để tự động
 * tạo / cập nhật / xóa slug trong bảng `slugs`.
 *
 * Bắt buộc khai báo 2 thuộc tính trong model:
 *   protected string $slugType  = 'code';   // slug_type trong bảng slugs
 *   protected string $slugField = 'name';   // cột dùng làm nguồn slug
 */
trait HasSlug
{
    public static function bootHasSlug(): void
    {
        // Sau khi tạo mới
        static::created(function (self $model) {
            Slug::sync($model->slugType, $model->getKey(), self::slugSource($model));
        });

        // Sau khi cập nhật (chỉ sync nếu field nguồn thay đổi)
        static::updated(function (self $model) {
            if ($model->wasChanged($model->slugField) || $model->wasChanged('name')) {
                Slug::sync($model->slugType, $model->getKey(), self::slugSource($model));
            }
        });

        // Sau khi xóa
        static::deleted(function (self $model) {
            Slug::remove($model->slugType, $model->getKey());
        });
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    /** Lấy slug string của bản ghi này */
    public function getSlugAttribute(): ?string
    {
        return Slug::of($this->slugType, $this->getKey());
    }

    protected static function slugSource(self $model): string
    {
        $source = trim((string) $model->{$model->slugField});

        if ($source === '') {
            $source = trim((string) ($model->name ?? ''));
        }

        return $source;
    }

    /** Lấy full URL của bản ghi này dùng slug */
    public function getSlugUrlAttribute(): string
    {
        $slug = $this->slug ?? $this->getKey();
        return url($this->slugPrefix . '/' . $slug);
    }
}

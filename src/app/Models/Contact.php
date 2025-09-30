<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    protected $casts = [
        'gender' => 'integer',
    ];

    protected $appends = [
        'full_name',
        'gender_label',
        'category_name',
    ];

    public const CATEGORY_MAP = [
        1 => '商品のお届けについて',
        2 => '商品の交換について',
        3 => '商品トラブル',
        4 => 'ショップへのお問い合わせ',
        5 => 'その他',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFullNameAttribute(): string
    {
        $parts = array_filter([$this->last_name, $this->first_name], static function ($v) {
            return $v !== null && $v !== '';
        });
        return implode(' ', $parts);
    }

    public function getGenderLabelAttribute(): string
    {
        $map = [
            1 => '男性',
            2 => '女性',
            3 => 'その他',
        ];
        return $map[$this->gender] ?? '未設定';
    }

    public function getCategoryNameAttribute(): string
    {
        $id = (int) ($this->category_id ?? 0);
        if ($id && isset(self::CATEGORY_MAP[$id])) {
            return self::CATEGORY_MAP[$id];
        }

        if ($this->relationLoaded('category') && $this->category) {
            foreach (['name','title','label','category','category_name'] as $col) {
                $val = $this->category->{$col} ?? null;
                if (is_string($val) && $val !== '') {
                    return $val;
                }
            }
        }

        if (($this->attributes['category'] ?? '') !== '') {
            return (string) $this->attributes['category'];
        }

        return self::CATEGORY_MAP[$this->category_id] ?? '未設定';
    }
}

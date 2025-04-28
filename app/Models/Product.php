<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[ObservedBy(ProductObserver::class)]
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'status',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function images() : Attribute{
        return Attribute::make(
            get: fn($value) => $this->getMedia('product-images')
        );
    }
}

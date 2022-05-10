<?php

// Model Namespacing.
namespace App\Models;

// Facades.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Enums
use App\Enums\PublishedState;

// Scopes
use App\Scopes\PublishedScope;

// Traits.
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Kalnoy\Nestedset\NodeTrait;

class Page extends Model implements HasMedia
{
    /**
    * Traits
    *
    */
    use HasFactory,
        InteractsWithMedia,
        NodeTrait;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        return static::addGlobalScope(new PublishedScope);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'page_title',
        'menu_title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'meta_tags',
        'og_title',
        'og_description',
        'og_slug',
        'og_type',
        'og_locale',
        'status',
        'published_at',
        'unpublished_at',
        'last_edited_administrator_id',
        'last_edit_at',
        'visible_in_menu',
        '_lft',
        '_rgt',
        'parent_id'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'administrator_id' => 'boolean',
        'category_id' => 'boolean',
        'state' => PublishedState::class,
        'published_at' => 'datetime',
        'unpublished_at' => 'datetime',
        'last_edited_administrator_id' => 'boolean',
        'last_edit_at' => 'datetime',
    ];

    /**
     * Model relations.
     *
     */
    public function navigation_menus()
    {
        return $this->belongsToMany(\App\Models\NavigationMenu::class);
    }

    /**
     * Register the files into the database with the given collection.
     *
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('pageOgImage')->singleFile();
    }
}

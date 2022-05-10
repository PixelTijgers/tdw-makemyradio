<?php

// Model Namespacing.
namespace App\Models;

// Facades.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

// Traits.
use Spatie\Permission\Traits\HasRoles;

class Social extends Model
{
    /**
     * Traits
     *
     */
    use HasRoles,
        NodeTrait;

    protected $fillable = [
        'social_media_id',
        'content',
        '_lft',
        '_rgt',
        'parent_id'
    ];

    /**
    * Model relations.
    *
    */
    public function socialmedia()
    {
        return $this->belongsTo(\App\Models\SocialMedia::class, 'social_media_id');
    }
}

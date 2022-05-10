<?php

// Model Namespacing.
namespace App\Models;

// Facades.
use Illuminate\Database\Eloquent\Model;

// Traits.
use Spatie\Permission\Traits\HasRoles;

class Details extends Model
{
    /**
     * Traits
     *
     */
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'contact',
        'street',
        'zip_code',
        'location',
        'country',
        'invoice_is_same',
        'iv_name',
        'iv_street',
        'iv_zip_code',
        'iv_location',
        'iv_country',
        'email',
        'phone',
        'mobile',
        'vat',
        'coc'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'invoice_is_same' => 'boolean',
        'category_id' => 'boolean',
    ];
}

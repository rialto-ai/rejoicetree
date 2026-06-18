<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'link', 'title', 'button_id', 'type_params', 'type', 'custom_icon',
        'block_type', 'block_params', 'review_status', 'support_type',
        'tax_deductible_claimed', 'support_entity_name', 'review_required',
    ];

    protected $casts = [
        'tax_deductible_claimed' => 'boolean',
        'review_required' => 'boolean',
    ];

    /**
     * Decode the block-specific structured fields (stored as JSON).
     */
    public function blockParams(): array
    {
        if (empty($this->block_params)) {
            return [];
        }

        return json_decode($this->block_params, true) ?: [];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
          if (config('linkstack.disable_random_link_ids') != 'true') {
            $numberOfDigits = config('linkstack.link_id_length') ?? 9;

            $minIdValue = 10**($numberOfDigits - 1);
            $maxIdValue = 10**$numberOfDigits - 1;

            do {
                $randomId = rand($minIdValue, $maxIdValue);
            } while (Link::find($randomId));

            $link->id = $randomId;
          }
        });
    }
}

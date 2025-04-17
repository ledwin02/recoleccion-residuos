<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'waste_type_id',
        'company_id',
        'collection_date',
        'collection_time',
        'frequency',
        'is_on_demand',
        'status',
        'notes',
        'weight',
        'points_earned',
    ];

    protected $casts = [
        'collection_date' => 'date',
        'collection_time' => 'datetime:H:i',
        'is_on_demand'   => 'boolean',
        'weight'         => 'float',
        'points_earned'  => 'integer',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wasteType(): BelongsTo
    {
        return $this->belongsTo(WasteType::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CollectorCompany::class, 'company_id');
    }

    // Accesor para el color del estado
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'yellow-500',
            'in_progress' => 'blue-500',
            'completed'   => 'green-500',
            'canceled'    => 'red-500',
            default       => 'gray-500',
        };
    }
}

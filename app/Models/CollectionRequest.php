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
    /**
     * Relación con el modelo User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo WasteType.
     */
    public function wasteType(): BelongsTo
    {
        return $this->belongsTo(WasteType::class);
    }

    /**
     * Relación con el modelo CollectorCompany.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CollectorCompany::class);
    }

    /**
     * Accesor para obtener el color asociado al estado de la solicitud.
     */
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

    // Ejemplo de método adicional: verificar si el usuario está activo
    /**
     * Verifica si el usuario asociado está activo.
     */
    public function isUserActive(): bool
    {
        return $this->user->is_active ?? false;  // Asegúrate de que el modelo User tenga el campo is_active
    }

    // Otro ejemplo, verificar si el usuario es administrador
    public function isUserAdmin(): bool
    {
        return $this->user->is_admin ?? false;  // Asegúrate de que el modelo User tenga el campo is_admin
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que pueden asignarse masivamente.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location_id',
        'role',
        'is_admin', // Campo is_admin agregado para asignación masiva
    ];

    /**
     * Atributos ocultos al serializar.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversiones de atributos.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Limpia el formato del teléfono (solo dígitos).
     *
     * @param  string  $value
     * @return void
     */
    public function setPhoneAttribute(string $value): void
    {
        $this->attributes['phone'] = preg_replace('/\D+/', '', $value);
    }

    /**
     * Relación: un usuario tiene muchas solicitudes de recolección.
     */
    public function collectionRequests(): HasMany
    {
        return $this->hasMany(CollectionRequest::class);
    }

    /**
     * Relación: un usuario pertenece a una ubicación.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Comprueba si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    /**
     * Comprueba si el usuario es recolector.
     */
    public function isCollector(): bool
    {
        return $this->role === 'collector';
    }

    /**
     * Asigna la contraseña hasheada automáticamente.
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Verifica si el usuario tiene su correo verificado.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }
}

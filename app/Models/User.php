<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail 
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROL_ADMIN = 1;
    const ROL_RECLUTADOR = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'permiso'
    ];

    //public $modo = 'S';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Constantes de permisos
    const PERMISO_TOTAL = 'total';
    const PERMISO_MEDIO = 'medio';
    const PERMISO_BAJO = 'bajo';

    /**
     * Verificar si el usuario tiene permiso total
     */
    public function tienePermisoTotal()
    {
        return $this->permisoNormalizado() === self::PERMISO_TOTAL;
    }

    /**
     * Verificar si el usuario tiene permiso medio o superior
     */
    public function tienePermisoMedio()
    {
        return in_array($this->permisoNormalizado(), [self::PERMISO_TOTAL, self::PERMISO_MEDIO]);
    }

    /**
     * Verificar si el usuario tiene al menos permiso bajo
     */
    public function tienePermisoBajo()
    {
        return in_array($this->permisoNormalizado(), [self::PERMISO_TOTAL, self::PERMISO_MEDIO, self::PERMISO_BAJO]);
    }

    public function permisoNormalizado()
    {
        if ($this->rol === self::ROL_ADMIN) {
            return self::PERMISO_TOTAL;
        }

        return $this->permiso ?: self::PERMISO_BAJO;
    }

    /**
     * Verificar si el usuario tiene un permiso específico o superior
     */
    public function tienePermiso($permiso)
    {
        $jerarquia = [
            self::PERMISO_BAJO => 1,
            self::PERMISO_MEDIO => 2,
            self::PERMISO_TOTAL => 3,
        ];

        $nivelUsuario = $jerarquia[$this->permisoNormalizado()] ?? 1;
        $nivelRequerido = $jerarquia[$permiso] ?? 0;

        return $nivelUsuario >= $nivelRequerido;
    }

    /**
     * Obtener el nombre legible del permiso
     */
    public function getNombrePermisoAttribute()
    {
        $nombres = [
            self::PERMISO_TOTAL => 'Permiso Total',
            self::PERMISO_MEDIO => 'Permiso Medio',
            self::PERMISO_BAJO => 'Permiso Bajo',
        ];

        return $nombres[$this->permisoNormalizado()] ?? 'Sin permiso';
    }
}

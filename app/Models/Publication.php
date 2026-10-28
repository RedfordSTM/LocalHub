<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publication extends Model
{
    use HasFactory;

    protected $table = 'publication';
    protected $primaryKey = 'id_publication';

    protected $fillable = [
        'titre', 
        'description', 
        'type', 
        'prix', 
        'ville', 
        'date_creation', 
        'id_utilisateur', 
        'id_categorie',
        'image_path',
        'statut'
    ];

    protected function casts(): array {
        return [
            'date_creation' => 'datetime',
            'prix' => 'decimal:2',
        ];
    }

    public function utilisateur(): BelongsTo {
        return $this->belongsTo(User::class, 'id_utilisateur', 'id_utilisateur');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'id_categorie', 'id_categorie');
    }

    public function scopeActive($query)
    {
        return $query->where('statut', 'active')
                     ->with(['utilisateur', 'category']) 
                     ->orderBy('date_creation', 'desc');
    }

    public function scopeOutils($query, ?string $ville = null)
    {
        $query->where('type', 'outil')
              ->where('statut', 'active')
              ->with(['utilisateur', 'category']);

        if ($ville !== null) {
            $query->where('ville', 'LIKE', '%' . $ville . '%');
        }

        return $query->orderBy('date_creation', 'desc');
    }

    public function reservations(): HasMany {
        return $this->hasMany(Reservation::class, 'id_publication', 'id_publication');
    }
}

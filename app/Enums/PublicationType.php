<?php

namespace App\Enums;

enum PublicationType: string
{
    case DEMANDE = 'demande';
    case OFFRE = 'offre';
    case ACTIVITE = 'activite';
    case INFO = 'info';

    public function label(): string
    {
        return match ($this) {
            self::DEMANDE => 'Demande (Besoin d\'aide)',
            self::OFFRE => 'Offre (Service / Objet)',
            self::ACTIVITE => 'Activité / Sortie',
            self::INFO => 'Information / Annonce',
        };
    }

    /** @return array<string, string> */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [$case->value => $case->label()])
            ->all();
    }
}

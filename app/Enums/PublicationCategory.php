<?php

namespace App\Enums;

enum PublicationCategory: string
{
    case SERVICES = 'services';
    case LOISIRS = 'loisirs';
    case VENTE = 'vente';
    case DONS = 'dons';
    case GARDE = 'garde';
    case COURS = 'cours';
    case PERDU_TROUVE = 'perdu_trouve';
    case AUTRE = 'autre';

    public function label(): string
    {
        return match ($this) {
            self::SERVICES => 'Entraide & Services',
            self::LOISIRS => 'Sorties & Loisirs',
            self::VENTE => 'Vente & Échange',
            self::DONS => 'Dons & Prêts',
            self::GARDE => 'Garde & Soins',
            self::COURS => 'Cours & Partage',
            self::PERDU_TROUVE => 'Perdu / Trouvé',
            self::AUTRE => 'Autre',
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

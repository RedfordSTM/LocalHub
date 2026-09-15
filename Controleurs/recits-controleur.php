<?php

declare(strict_types=1);

$nomProjet = 'LocalHub';
$auteur = 'Redford S. St-M.';
$titrePage = 'Récits utilisateurs - ' . $nomProjet;

$recits = [
    [
        'id' => 1,
        'titre' => "Publication d'une demande d'aide (Entraide)",
        'description' => "En tant que résident, je veux publier une demande d'aide locale afin de recevoir l'assistance d'un voisin disponible.",
        'criteres' => [
            "Le formulaire valide que le titre, la description et la catégorie sont bien remplis.",
            "La demande d'aide s'affiche immédiatement dans la liste publique des requêtes du quartier.",
            "L'auteur peut marquer la demande comme « Résolue » une fois l'aide obtenue."
        ]
    ],
    [
        'id' => 2,
        'titre' => "Prêt et partage de matériel",
        'description' => "En tant que membre, je veux proposer un outil ou un équipement à prêter afin d'en faire profiter les membres de ma communauté.",
        'criteres' => [
            "La fiche de l'objet inclut une photo, une description et les conditions de prêt (ex. durée max, caution).",
            "Un bouton permet aux autres utilisateurs de soumettre une demande d'emprunt avec une date de début et de fin.",
            "Le propriétaire reçoit une notification/statut en attente pour accepter ou refuser la réservation."
        ]
    ],
    [
        'id' => 3,
        'titre' => "Offre de service de proximité",
        'description' => "En tant que prestataire bénévole ou local, je veux publier un service que j'offre afin que mes voisins puissent me contacter.",
        'criteres' => [
            "Le service permet de préciser le domaine d'expertise (ex. jardinage, cours particuliers, bricolage).",
            "Les utilisateurs peuvent filtrer la recherche de services par catégorie.",
            "Chaque service affiche le profil de l'offreur avec son évaluation moyenne."
        ]
    ],
    [
        'id' => 4,
        'titre' => "Vente d'objets de seconde main",
        'description' => "En tant qu'utilisateur, je veux mettre en vente un objet usagé afin de lui donner une seconde vie localement.",
        'criteres' => [
            "Le formulaire exige la saisie d'un prix en dollars et d'au moins un état de l'objet (ex. Bon état, Neuf).",
            "L'annonce passe automatiquement au statut « Vendu » lorsque la transaction est confirmée.",
            "L'annonceur peut modifier ou supprimer son offre à tout moment depuis son espace."
        ]
    ],
    [
        'id' => 5,
        'titre' => "Organisation et inscription à une activité communautaire",
        'description' => "En tant qu'organisateur, je veux créer une activité locale (ex. nettoyage de parc, cours de groupe) afin de rassembler des participants.",
        'criteres' => [
            "L'activité affiche une date, une heure, un lieu précis et un nombre maximal de participants.",
            "Les membres peuvent cliquer sur « Participer » et le compteur de places disponibles s'ajuste en temps réel.",
            "Si le nombre maximum de participants est atteint, l'inscription est verrouillée."
        ]
    ],
    [
        'id' => 6,
        'titre' => "Messagerie entre membres",
        'description' => "En tant qu'acheteur ou emprunteur, je veux envoyer un message privé au propriétaire d'une publication afin de planifier la remise de l'objet ou du service.",
        'criteres' => [
            "Une conversation s'ouvre directement depuis la page de la publication concernée.",
            "L'historique des échanges est conservé et classé par interlocuteur.",
            "Un indicateur visuel informe l'utilisateur lorsqu'il reçoit un nouveau message."
        ]
    ],
    [
        'id' => 7,
        'titre' => "Évaluation et avis après transaction",
        'description' => "En tant que membre ayant complété un échange ou service, je veux évaluer l'autre utilisateur afin de renforcer la confiance au sein de la plateforme.",
        'criteres' => [
            "L'évaluation est accessible uniquement si la transaction a été marquée comme « Complétée ».",
            "L'utilisateur laisse une note sur 5 étoiles ainsi qu'un commentaire textuel optionnel.",
            "La note moyenne recalculée s'affiche publiquement sur le profil du membre évalué."
        ]
    ],
    [
        'id' => 8,
        'titre' => "Recherche et filtrage par proximité",
        'description' => "En tant que visiteur ou membre, je veux filtrer les publications selon leur proximité afin de voir uniquement les annonces de mon quartier.",
        'criteres' => [
            "La recherche permet de filtrer par code postal, secteur ou rayon de distance.",
            "Les résultats affichent en priorité les publications les plus proches géographiquement.",
            "Un message clair est affiché si aucune publication n'est disponible dans le secteur sélectionné."
        ]
    ]
];

require __DIR__ . '/../Vues/recits.php';

<?php

namespace App\Twig;

use Twig\TwigFilter;

class RoleExtension extends \Twig\Extension\AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('normalizeRole', [$this, 'normalizeRoleFilter']),
        ];
    }

    public function normalizeRoleFilter($roles)
    {
        // Utiliser la fonction reset() pour obtenir le premier élément du tableau
        $role = reset($roles);

        // Logique pour normaliser les rôles
        // Utilisez un switch, un tableau associatif ou toute autre logique pour effectuer la conversion
        switch ($role) {
            case 'ROLE_USER':
                return 'utilisateur';
            case 'ROLE_OWNER':
                return 'propriétaire';
            case 'ROLE_TENANT':
                return 'locataire';
            case 'ROLE_ADMIN':
                return 'administrateur';
            default:
                return $role; // Rôle d'origine si aucune conversion n'est trouvée
        }
    }
}

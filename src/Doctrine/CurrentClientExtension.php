<?php

namespace App\Doctrine;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;

class CurrentClientExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // linked to QueryCollectionExtensionInterface
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {
        $this->addWhere($resourceClass,$queryBuilder);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
    {
        $this->addWhere($resourceClass,$queryBuilder);
    }

    private function addWhere(string $resourceClass, QueryBuilder $queryBuilder)
    {
        if ($resourceClass === User::class) {
            $alias = $queryBuilder->getRootAliases()[0];
            // security->getUser returns a JWT configuration of the Client objet, notably with createFromPayload and JWTUserInterface
            $queryBuilder
                ->andWhere("$alias.client = :current_client")
                ->setParameter("current_client", $this->security->getUser()->getId());
        }

    }
}

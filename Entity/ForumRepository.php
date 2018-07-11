<?php

namespace Yosimitso\WorkingForumBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class ForumRepository
 *
 * @package Yosimitso\WorkingForumBundle\Entity
 */
class ForumRepository extends EntityRepository
{
    /**
     * @param \Application\Sonata\UserBundle\Entity\User $currentUser
     * @return array
     */
    public function findBySecteur(\Application\Sonata\UserBundle\Entity\User $currentUser)
    {
        $qb = $this
            ->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC');

        if ($currentUser->isCoiffure() === $currentUser->isEsthetique()) {
            if ($currentUser->isCoiffure()) {
                $qb->where(
                    $qb->expr()->orX(
                        $qb->expr()->eq('f.isCoiffure', (int)$currentUser->isCoiffure()),
                        $qb->expr()->eq('f.isCoiffure', (int)$currentUser->isEsthetique())
                    )
                );
            } else {
                $qb->where(
                    $qb->expr()->andX(
                        $qb->expr()->eq('f.isCoiffure', (int)$currentUser->isCoiffure()),
                        $qb->expr()->eq('f.isCoiffure', (int)$currentUser->isEsthetique())
                    )
                );
            }
        } else if ($currentUser->isCoiffure() === true) {
            $qb->where('f.isCoiffure IS TRUE');
        } else if ($currentUser->isEsthetique() === true) {
            $qb->where('f.isEsthetique IS TRUE');
        }

        // 'OR (f.is_coiffure IS NULL AND f.is_esthetique IS NULL)';
        $qb->orWhere(
            $qb->expr()->andX(
                $qb->expr()->isNull('f.isCoiffure'),
                $qb->expr()->isNull('f.isEsthetique')
            )
        );

        return $qb
            ->getQuery()
            ->getResult();
    }
}

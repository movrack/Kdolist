<?php

namespace Manudev\KDOBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Manudev\UserBundle\Entity\User;
use Manudev\KDOBundle\Entity\Lists;

/**
 * ListsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ListsRepository extends NestedTreeRepository
{

    public function listForUserQueryBuilder(User $user, $withSubList = NULL)
    {
        $query = $this->createQueryBuilder('list')
            ->join('list.users', 'u', 'WITH', 'u.id = :userId')
            ->setParameter('userId', $user->getId())
        ;

        if (!$withSubList) {
            $query->where('list.parent is NULL');
        }

        return $query;
    }

    public function listForUser(User $user, $withSubList = NULL) {
        return $this->listForUserQueryBuilder($user, $withSubList)->getQuery()->getResult();
    }

    public function parentsQueryBuilder(Lists $entity)
    {
        $query = $this->createQueryBuilder('list')
            ->where('list.root = :root')
            ->andWhere('list.lft < :lft')
            ->setParameter('root', $entity->getRoot())
            ->setParameter('lft', $entity->getLft())
            ->orderBy('list.lvl', 'ASC')
        ;

        return $query;
    }

    public function parents(Lists $entity) {
        return $this->parentsQueryBuilder($entity)->getQuery()->getResult();
    }



}

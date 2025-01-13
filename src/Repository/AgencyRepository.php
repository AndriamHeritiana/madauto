<?php

namespace App\Repository;

use App\Entity\Agency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Agency>
 *
 * @method Agency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agency[]    findAll()
 * @method Agency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agency::class);
    }

    public function save(Agency $agency, bool $flush = false): void
    {
        $this->getEntityManager()->persist($agency);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Agency $agency, bool $flush = false): void
    {
        $this->getEntityManager()->remove($agency);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCity(string $city): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.city = :city')
            ->setParameter('city', $city)
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

}

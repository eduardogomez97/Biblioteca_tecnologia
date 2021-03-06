<?php

namespace App\Repository;

use App\Entity\Biblioteca;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Biblioteca|null find($id, $lockMode = null, $lockVersion = null)
 * @method Biblioteca|null findOneBy(array $criteria, array $orderBy = null)
 * @method Biblioteca[]    findAll()
 * @method Biblioteca[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BibliotecaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Biblioteca::class);
    }
    
    public function BuscarTodasLasBibliotecas() {
        return $this->createQueryBuilder('biblio')
        ->select('biblio.id, biblio.nombre, biblio.num_trabajadores, biblio.direccion, biblio.fecha_fundacion ')
        ->getQuery()
        ->getResult(Query::HYDRATE_ARRAY);

    }

    // /**
    //  * @return Biblioteca[] Returns an array of Biblioteca objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Biblioteca
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

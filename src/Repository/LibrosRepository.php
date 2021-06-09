<?php

namespace App\Repository;

use App\Entity\Libros;
use App\Entity\Biblioteca;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method Libros|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libros|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libros[]    findAll()
 * @method Libros[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibrosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libros::class);
    }
    public function BuscarTodasLasLibros(int $id)  {
        $getlibros = $this->createQueryBuilder('lib')
        ->select('lib.id, lib.titulo, lib.autor, lib.tipo, lib.fecha_publicacion, lib.ejemplares')
        ->where('lib.biblioteca = :id')
        ->setParameter(":id", $id)
        ->getQuery()
        ->getArrayResult();
        return $getlibros;

    }
    
    // /**
    //  * @return Libros[] Returns an array of Libros objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Libros
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

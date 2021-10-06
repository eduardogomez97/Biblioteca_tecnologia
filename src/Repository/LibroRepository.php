<?php

namespace App\Repository;

use App\Entity\Libro;
use App\Entity\Biblioteca;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method Libro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libro[]    findAll()
 * @method Libro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libro::class);
    }
    public function BuscarTodosLosLibros(int $id)  {
        $getlibros = $this->createQueryBuilder('lib')
        ->select('lib.id, lib.titulo, lib.autor, lib.tipo, lib.fecha_publicacion, lib.ejemplares')
        ->where('lib.biblioteca = :id')
        ->setParameter(":id", $id)
        ->getQuery()
        ->getArrayResult();
        return array($getlibros);

    }
    
    // /**
    //  * @return Libro[] Returns an array of Libro objects
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
    public function findOneBySomeField($value): ?Libro
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

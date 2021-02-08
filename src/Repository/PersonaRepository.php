<?php

namespace App\Repository;

use App\Entity\Persona;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Persona|null find($id, $lockMode = null, $lockVersion = null)
 * @method Persona|null findOneBy(array $criteria, array $orderBy = null)
 * @method Persona[]    findAll()
 * @method Persona[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Persona::class);
    }

    // /**
    //  * @return Persona[] Returns an array of Persona objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Persona
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



//      Find all personal  Devuelve todos los contactos de la lista personal
//        return $this -> createQueryBuilder("p")
//                     ->andWhre('p.agenda = :valagenda'/* Nombre que le ponemos nosotros  ) /* Condicion, no se pude pasar parametro */
//                     ->setParameter('valagenda, pers ' //nombre que le ponemos al campo de personal y profesional)
//                     ->orderby('c.id','ASC')
//                     ->getQuery()
//                     ->getResult()




//    Find all profesional Devuelve todos los contactos de la lista profesional 
//         return $this -> createQueryBuilder("p")
//                     ->andWhre('p.agenda = :valagenda'/* Nombre que le ponemos nosotros  ) /* Condicion, no se pude pasar parametro */
//                     ->setParameter('valagenda, 'prof'  //nombre que le ponemos al campo de personal y profesional)
//                     ->orderby('c.id','ASC')
//                     ->getQuery()
//                     ->getResult()


//    Find all personas Devuelbe todos los contactos
//        
// 
// 
//
//
//
}

<?php

namespace App\Repository;

use App\Entity\Department;
use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\StudentRepository;

/**
 * @extends ServiceEntityRepository<Department>
 *
 * @method Department|null find($id, $lockMode = null, $lockVersion = null)
 * @method Department|null findOneBy(array $criteria, array $orderBy = null)
 * @method Department[]    findAll()
 * @method Department[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    public function add(Department $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Department $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function saveDepartment($DepartmentName, $DepartmentId, $Address)
    {
        $newDepartment = new Department();

        $newDepartment
            ->setDepartmentName($DepartmentName)
            ->setDepartmentId($DepartmentId)
            ->setAddress($Address);


        $this->getEntityManager()->persist($newDepartment);
        $this->getEntityManager()->flush();
    }

    public function assignStudent(int $id,int $studentId,StudentRepository  $studentRepository, bool $flush = false): void
{
    $student= $studentRepository->find($studentId);
    $department=$this->find($id);
    $department->addStudent($student);

    $this->getEntityManager()->refresh($department);

    if ($flush) {
        $this->getEntityManager()->flush();
    }

}
//    /**
//     * @return Department[] Returns an array of Department objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Department
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

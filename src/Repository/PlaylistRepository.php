<?php
namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 * @extends ServiceEntityRepository<Playlist>
 *
 * @method Playlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playlist[] findAll()
 * @method Playlist[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylistRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    public function add(Playlist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Playlist $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAll(): array
    {
        $rawres = $this->_em->createQueryBuilder()
            ->select('p', 'COUNT(f.id) AS formationsCount')
            ->from(Playlist::class, 'p')
            ->leftjoin('p.formations', 'f')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();

        foreach ($rawres as $r) {
            $r[0]->setFormationsCount($r['formationsCount']);
            $res[] = $r[0];
        }

        return $res;
    }

    /**
     * Retourne toutes les playlists triées sur le nom de la playlist
     *
     * @param string $champ
     * @param string $ordre
     * @return Playlist[]
     */
    public function findAllOrder(string $field, string $order): array
    {
        $rawres = $this->_em->createQueryBuilder()
            ->select('p', 'COUNT(f.id) AS formationsCount')
            ->from(Playlist::class, 'p')
            ->leftjoin('p.formations', 'f')
            ->groupBy('p.id')
            ->orderBy($field, $order)
            ->getQuery()
            ->getResult();

        foreach ($rawres as $r) {
            $r[0]->setFormationsCount($r['formationsCount']);
            $res[] = $r[0];
        }

        return $res;
    }

    /**
     * Enregistrements dont un champ contient une valeur
     * ou tous les enregistrements si la valeur est vide
     *
     * @param string $champ
     * @param string $valeur
     * @param string $table
     *            si $champ dans une autre table
     * @return Playlist[]
     */
    public function findByContainValue(string $champ, string $valeur, string $table = ""): array
    {
        if ($valeur == "") {
            return $this->findAllOrderByName('ASC');
        }

        if ($table == "") {
            return $this->createQueryBuilder('p')
                ->leftjoin('p.formations', 'f')
                ->where('p.' . $champ . ' LIKE :valeur')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->groupBy('p.id')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('p')
                ->leftjoin('p.formations', 'f')
                ->leftjoin('f.categories', 'c')
                ->where('c.' . $champ . ' LIKE :valeur')
                ->setParameter('valeur', '%' . $valeur . '%')
                ->groupBy('p.id')
                ->orderBy('p.name', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }
}

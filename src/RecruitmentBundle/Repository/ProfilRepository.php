<?php

namespace RecruitmentBundle\Repository;

/**
 * ProfilRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfilRepository extends \Doctrine\ORM\EntityRepository
{
	public function getCandidatSociete($_societe)
	{
		$results = array();
		$qb = $this->createQueryBuilder('p');

		$candidats = $qb->select('IDENTITY(c.candidat)')
			->from('RecruitmentBundle:Candidature', 'c')
          	->innerJoin('c.offre','o')
			->where('o.user = :societe')
          	->setParameters(array('societe'=> $_societe))
          	->getQuery()
          	->getResult();

        if(count($candidats) > 0)
        {
        	$query = $this->createQueryBuilder('p')
        	->where("p.id IN (:candidats)")
              	->setParameters(array('candidats'=> $candidats))
              	->getQuery();
            $results = $query->getResult();
        }		
		return $results;
	}

	public function countChercheur()
	{
		$query = $this->createQueryBuilder('p')
				->select('count(p.id) as nb')
				->where("p.statut = 'chercheur'")
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}
}

<?php

namespace RecruitmentBundle\Repository;

/**
 * CandidatureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CandidatureRepository extends \Doctrine\ORM\EntityRepository
{
	public function countUserCandidature($user)
	{
		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
              	->where("c.candidat = :user")
              	->groupBy('c.candidat')
              	->setParameters(array('user'=> $user))
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function getCandidatureSociete($user,$type)
	{
		$parameters = array();

		$parameters['societe'] = $user;
		$condition = " 1 = 1";	

		if($type != "tous")
		{
			$condition .= " AND c.statut = :statut";
			$parameters['statut'] = $type;
		}

		$query = $this->createQueryBuilder('c')
				->innerJoin('c.offre','o')
				->where('o.user = :societe')
				->andWhere("c.statut <> 'draft'")
              	->andWhere($condition)
              	->setParameters($parameters)
              	->getQuery();
		$results = $query->getResult();
		return $results;
	}

	public function countCandidatureByStatus($type,$user)
	{
		$parameters = array();

		$parameters['societe'] = $user;
		$condition = "c.statut = :statut";
		$parameters['statut'] = $type;

		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->innerJoin('c.offre','o')
				->where('o.user = :societe')
				->andWhere("c.statut <> 'draft'")
              	->andWhere($condition)
              	->groupBy('c.statut')
              	->setParameters($parameters)
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countSocieteCandidature($user)
	{
		$parameters = array();

		$parameters['societe'] = $user;

		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->innerJoin('c.offre','o')
				->where('o.user = :societe')
				->andWhere("c.statut <> 'draft'")
              	->andWhere($condition)
              	->groupBy('o.user')
              	->setParameters($parameters)
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countAllCandidature()
	{
		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->where("c.statut <> 'draft'")
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countAllTestCandidature()
	{
		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->where("c.statut <> 'draft'")
				->andWhere('c.dateTest IS NOT NULL')
				->andWhere("c.statut <> 'validation'")
				->andWhere("c.statut <> 'entretien'")
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countAllEntretienCandidature()
	{
		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->where("c.statut <> 'draft'")
				->andWhere('c.dateEntretien IS NOT NULL')
				->andWhere("c.statut <> 'validation'")
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countAllOkCandidature()
	{
		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->where("c.statut = 'validation'")
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countUserCandidatureByStatus($type,$user)
	{
		$parameters = array();
		$parameters['user'] = $user;
		$condition = "c.statut = :statut";
		$parameters['statut'] = $type;

		$query = $this->createQueryBuilder('c')
				->select('count(c.id) as nb')
				->where('c.candidat = :user')
              	->andWhere($condition)
              	->groupBy('c.statut')
              	->setParameters($parameters)
              	->getQuery();
		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function countCandidatureByOffre($offres)
	{
		$query = $this->createQueryBuilder('c')
				->select('o.id,count(c.id) as nb')
				->innerJoin('c.offre','o')
				->where('o.id IN (:offres)')
				->setParameters(array('offres'=>$offres))
              	->groupBy('o.id')
              	->getQuery();
		return $query->getResult();
	}

	public function getNoteAvgByOffre($offres)
	{
		$query = $this->createQueryBuilder('c')
				->select('o.id,avg(c.note) as nb')
				->innerJoin('c.offre','o')
				->where('o.id IN (:offres)')
				->setParameters(array('offres'=>$offres))
              	->groupBy('o.id')
              	->getQuery();
		return $query->getResult();
	}

	public function getUserCandidature($user)
	{
		$query = $this->createQueryBuilder('c')
				->select('IDENTITY(c.offre)')
				->innerJoin('c.offre','o')
				->innerJoin('c.candidat','p')
              	->where("p.candidat = :user")
              	->setParameters(array('user'=> $user))
              	->getQuery();
		
	    $results = $query->getResult();

	    //$offre_id = array();
	    
	    if(count($results) > 0)
	    {
	    	//var_dump($results[0]);die;
	    	return $results[0];
	    }


	}

	public function getUserCandidatureByStatus($user,$type,$filtre)
	{
		$condition = "c.candidat = :user";

		$parameters = array();
		$parameters['user'] = $user;

		if($type != "tous")
		{
			$condition .= " AND c.statut = :statut";
			$parameters['statut'] = $type;
		}

		if($filtre && $filtre != "")
		{
			$condition .= " AND (o.intitule LIKE :filtre OR s.nom LIKE :filtre)";
			$parameters['filtre'] = '%'.$filtre.'%';
		}

		$query = $this->createQueryBuilder('c')              	
              	->innerJoin("c.offre",'o')
              	->innerJoin("o.user","s")
              	->where($condition)
              	->setParameters($parameters)
              	->getQuery();
		
	    $results = $query->getResult();
	    return $results;
	}

	public function getOthers($offre,$candidature)
	{
		$query = $this->createQueryBuilder('c')
              	->where("c.offre = :offre")
              	->andWhere("c.id <> :candidature")
              	->andWhere("c.statut IN ('new','test','entretien')")
              	->setParameters(array('offre'=> $offre,'candidature'=>$candidature))
              	->getQuery();
		
	    $results = $query->getResult();
	    return $results;
	}
}

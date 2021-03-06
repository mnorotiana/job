<?php

namespace RecruitmentBundle\Repository;

/**
 * OffreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OffreRepository extends \Doctrine\ORM\EntityRepository
{	
	public function getOffreByStatus($_ville,$_domaine,$_filtre,$_statut,$_user)
	{
		$qb = $this->createQueryBuilder('offr');		

		$parameters = array();
		$parameters['statut'] = $_statut;
		$condition = "1 = 1";
		if($_filtre)
		{
			$condition .= " AND (offr.lieu like :filtre OR offr.domaine like :filtre OR offr.intitule like :filtre OR offr.description like :filtre OR offr.qualifications like :filtre OR s.nom like :filtre )";
			$parameters['filtre'] = '%'.$_filtre.'%';
		}
		else
		{
			if($_ville)
			{
				$condition .= " AND offr.lieu like :lieu";
				$parameters['lieu'] = '%'.$_ville.'%';
			}

			if($_domaine)
			{
				$condition .= " AND offr.domaine like :domaine";
				$parameters['domaine'] = '%'.$_domaine.'%';
			}
		}

		$removedOffre = $qb->select('IDENTITY(r.offre)')
			->from('RecruitmentBundle\Entity\RemovedOffre', 'r')
          	->where("r.user = :user")
          	->setParameters(array('user'=> $_user))
          	->getQuery()
          	->getResult();

        $removed = array();
      	foreach ($removedOffre as $key => $arr_removed) {
      		foreach ($arr_removed as $ind => $id) {
      			if(!in_array($id, $removed))
      			{
      				$removed[] = (int)$id;
      			}
      		}
      	}
      	if(count($removed) > 0)
		{
			$condition .= " AND offr.id NOT IN (:removed)";
			$parameters['removed'] = $removed;
		}

		$query = $this->createQueryBuilder('offr')
		->innerJoin('offr.user','s')
		->where("offr.statut = :statut")
		->andWhere($condition)
		->setParameters($parameters)
		->getQuery();

		$results = $query->getResult();
		return $results;
	}

	public function countOffreByStatus($_ville,$_domaine,$_societe,$_statut)
	{
		$parameters = array();

		$parameters['statut'] = $_statut;
		$condition = "1 = 1";

		if($_ville)
		{
			$condition .= " AND o.lieu = :lieu";
			$parameters['lieu'] = $_ville;
		}

		if($_domaine)
		{
			$condition .= " AND o.domaine = :domaine";
			$parameters['domaine'] = $_domaine;
		}

		if($_societe)
		{
			$condition .= " AND o.user = :societe";
			$parameters['societe'] = $_societe;
		}


		$query = $this->createQueryBuilder('o')
		->select('count(o.id) as nb')
		->where("o.statut = :statut")
		->andWhere($condition)
		->groupBy('o.statut')
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

	public function countOffre($_ville,$_domaine,$_societe)
	{
		$parameters = array();

		
		$condition = "1 = 1";

		if($_ville)
		{
			$condition .= " AND o.lieu = :lieu";
			$parameters['lieu'] = $_ville;
		}

		if($_domaine)
		{
			$condition .= " AND o.domaine = :domaine";
			$parameters['domaine'] = $_domaine;
		}

		if($_societe)
		{
			$condition .= " AND o.user = :societe";
			$parameters['societe'] = $_societe;
		}

		$query = $this->createQueryBuilder('o')
		->select('count(o.id) as nb')
		->where($condition)
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

	public function countOffreDomaine($domaines,$user)
	{

		$qb = $this->createQueryBuilder('offr');

        $query = $this->createQueryBuilder('offr')
				->select('count(offr.id) as nb')
              	->where("offr.statut = 'published'")
              	->andWhere("offr.domaine LIKE :domaines")
              	->groupBy('offr.statut')
              	->setParameters(array('domaines'=> '%'.$domaines.'%'))
              	->getQuery();

		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function getOpenOffreDomaine($domaines,$user)
	{

		$qb = $this->createQueryBuilder('offr');

		$removedOffre = $qb->select('IDENTITY(r.offre)')
			->from('RecruitmentBundle\Entity\RemovedOffre', 'r')
          	->where("r.user = :user")
          	->setParameters(array('user'=> $_user))
          	->getQuery()
          	->getResult();

        $condition = "1 = 1";
        $parameters = array();

        $removed = array();        
      	foreach ($removedOffre as $key => $arr_removed) {
      		foreach ($arr_removed as $ind => $id) {
      			if(!in_array($id, $removed))
      			{
      				$removed[] = (int)$id;
      			}
      		}
      	}

      	if(count($removed) > 0)
		{
			$condition .= " AND offr.id NOT IN (:removed)";
			$parameters['removed'] = $removed;
		}

		if(count($domaines) > 0)
		{
			$condition .= " AND (";
			$separator = "";
			foreach ($domaines as $key => $domaine) {
				$condition .= $separator."offr.domaine LIKE '%".$domaine."%' OR offr.intitule LIKE '%".$domaine."%'";
				$separator = " OR ";
			}

			$condition .=")";			
		}

        $query = $this->createQueryBuilder('offr')
              	->where("offr.statut = 'published'")
              	->andWhere($condition)
              	->setParameters($parameters)
              	->getQuery();

	    return $query->getResult();
	}

	public function getOpenOffreSociete($societes,$_user)
	{

		$qb = $this->createQueryBuilder('offr');
		$removedOffre = $qb->select('IDENTITY(r.offre)')
			->from('RecruitmentBundle\Entity\RemovedOffre', 'r')
          	->where("r.user = :user")
          	->setParameters(array('user'=> $_user))
          	->groupBy('r.offre')
          	->getQuery()
          	->getResult();

		$condition = "1 = 1";
        $parameters = array();

        $removed = array();        
      	foreach ($removedOffre as $key => $arr_removed) {
      		foreach ($arr_removed as $ind => $id) {
      			if(!in_array($id, $removed))
      			{
      				$removed[] = (int)$id;
      			}
      		}
      	}

      	if(count($removed) > 0)
		{
			$condition .= " AND offr.id NOT IN (:removed)";
			$parameters['removed'] = $removed;
		}



		$parameters['societes'] = $societes;

        $query = $this->createQueryBuilder('offr')
              	->where("offr.statut = 'published'")
              	->andWhere("offr.user IN (:societes)")
              	->andWhere($condition)
              	->setParameters($parameters)
              	->getQuery();
              	
	    return $query->getResult();
	}

	public function getOpenOffreSocietesOrDomaines($societes,$domaines,$_user)
	{

		$qb = $this->createQueryBuilder('offr');
		$removedOffre = $qb->select('IDENTITY(r.offre)')
			->from('RecruitmentBundle\Entity\RemovedOffre', 'r')
          	->where("r.user = :user")
          	->setParameters(array('user'=> $_user))
          	->groupBy('r.offre')
          	->getQuery()
          	->getResult();

      	$condition = "1 = 1";
        $parameters = array();

        $removed = array();        
      	foreach ($removedOffre as $key => $arr_removed) {
      		foreach ($arr_removed as $ind => $id) {
      			if(!in_array($id, $removed))
      			{
      				$removed[] = (int)$id;
      			}
      		}
      	}

      	if(count($removed) > 0)
		{
			$condition .= " AND offr.id NOT IN (:removed)";
			$parameters['removed'] = $removed;
		}


		if(count($domaines) > 0 || count($societes) > 0)
		{
			$condition .= " AND (";
			$separator = "";
			foreach ($domaines as $key => $domaine) {
				$condition .= $separator."offr.domaine LIKE '%".$domaine."%' OR offr.intitule LIKE '%".$domaine."%'";
				$separator = " OR ";
			}

			foreach ($societes as $key => $societe) {
				$condition .= $separator."s.nom LIKE '".$societe."'";
				$separator = " OR ";
			}

			$condition .=")";			
		}

        $query = $this->createQueryBuilder('offr')
        		->innerJoin('offr.user','s')
              	->where("offr.statut = 'published'")
              	->andWhere($condition)
              	->setParameters($parameters)
              	->getQuery();
              	
	    return $query->getResult();
	}

	public function countAllOffre()
	{
		$parameters = array();
		$query = $this->createQueryBuilder('o')
		->select('count(o.id) as nb')
		->where("o.statut <> 'draft'")
		->getQuery();

		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function getAllOffre()
	{
		$parameters = array();
		$query = $this->createQueryBuilder('o')
		->where("o.statut <> 'draft'")
		->getQuery();

		return $query->getResult();
	}

	public function countAllOffreByStatus($_statut)
	{
		$parameters = array();
		$query = $this->createQueryBuilder('o')
		->select('count(o.id) as nb')
		->where("o.statut = :statut")
		->groupBy('o.statut')
		->setParameters(array('statut'=>$_statut))
		->getQuery();

		try
	    {
	        return $query->getSingleScalarResult(); 
	    }
	    catch(\Doctrine\ORM\NoResultException $e) {
	        return 0;
	    }
	}

	public function getClosed($_date)
	{
		$query = $this->createQueryBuilder('o')		
		->where("o.statut <> 'closed'")
		->andWhere("o.dateCloture < :date")
		->setParameters(array('date'=>$_date))
		->getQuery();

		return $query->getResult();
	}
}

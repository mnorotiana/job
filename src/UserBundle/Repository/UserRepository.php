<?php

namespace UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
	public function findByRole($role)
	{
	    $qb = $this->createQueryBuilder('u')	    
	        ->where('u.roles LIKE :roles')
	        ->setParameters(array('roles'=>'%"'.$role.'"%'));
	    return $qb->getQuery()->getResult();
	}


	public function findByRoleAndName($role,$name)
	{
	    $qb = $this->createQueryBuilder('u')	    
	        ->where('u.roles LIKE :roles')
	        ->andWhere('u.nom LIKE :name')
	        ->setParameters(array('roles'=>'%"'.$role.'"%','name'=>$name));

	    $results = $qb->getQuery()->getResult();
	    if(count($results) > 0)
	    {
	    	return $results[0];
	    }
	    return null;
	}

	public function getActive($_role)
	{
		// Comme vous le voyez, le délais est redondant ici, l'idéale serait de le rendre configurable via votre bundle
		$delay = new \DateTime();
		$delay->setTimestamp(strtotime('30 minutes ago'));

		$qb = $this->createQueryBuilder('u')
			->where('u.lastActivity > :delay')
			->andWhere('u.roles NOT LIKE :role')
			->orderBy('u.nom','ASC')
			->setParameters(array('delay'=>$delay,'role'=>$_role))
		;

		return $qb->getQuery()->getResult();
	}
}

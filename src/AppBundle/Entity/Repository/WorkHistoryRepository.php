<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Team;
use AppBundle\Entity\WorkHistory;
use Doctrine\ORM\EntityRepository;

/**
 * WorkHistoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WorkHistoryRepository extends EntityRepository
{

	/**
	 * @return WorkHistory[]
	 */
	public function findActiveWorkHistories()
	{

		$today = new \DateTime('now');
		return $this->createQueryBuilder('whistory')
			->select('whistory')
			->join('whistory.startSemester', 'startSemester')
			->leftJoin('whistory.endSemester', 'endSemester')
			->where('startSemester.semesterStartDate < :today')
			->andWhere('endSemester is null or endSemester.semesterEndDate > :today')
			->setParameter('today', $today)
			->getQuery()
			->getResult();
	}

	/**
	 * @param Team $team
	 * @return WorkHistory[]
	 */
	public function findActiveWorkHistoriesByTeam($team)
	{
		$today = new \DateTime('now');
		return $this->createQueryBuilder('whistory')
			->select('whistory')
			->join('whistory.startSemester', 'startSemester')
			->leftJoin('whistory.endSemester', 'endSemester')
			->where('startSemester.semesterStartDate < :today')
			->andWhere('whistory.team = :team')
			->andWhere('endSemester is null or endSemester.semesterEndDate > :today')
			->setParameter('today', $today)
			->setParameter('team', $team)
			->getQuery()
			->getResult();
	}

	/**
	 * @param Team $team
	 * @return WorkHistory[]
	 */
	public function findInActiveWorkHistoriesByTeam($team)
	{

		$today = new \DateTime('now');
		return $this->createQueryBuilder('whistory')
			->select('whistory')
			->join('whistory.startSemester', 'startSemester')
			->leftJoin('whistory.endSemester', 'endSemester')
			->where('startSemester.semesterStartDate < :today')
			->andWhere('whistory.team = :team')
			->andWhere('endSemester.semesterEndDate < :today')
			->setParameter('today', $today)
			->setParameter('team', $team)
			->getQuery()
			->getResult();
	}

	/**
	 * @param $user
	 * @return WorkHistory[]
	 */
	public function findActiveWorkHistoriesByUser($user)
	{

		$today = new \DateTime('now');
		return $this->createQueryBuilder('whistory')
			->select('whistory')
			->join('whistory.startSemester', 'startSemester')
			->leftJoin('whistory.endSemester', 'endSemester')
			->where('startSemester.semesterStartDate < :today')
			->andWhere('whistory.user = :user')
			->andWhere('endSemester.semesterEndDate < :today')
			->setParameter('today', $today)
			->setParameter('user', $user)
			->getQuery()
			->getResult();
	}

	public function findWorkHistoriesByDepartment($department)
	{

		$today = new \DateTime('now');
		$workHistories = $this->getEntityManager()->createQuery("
			SELECT whistory
			FROM AppBundle:WorkHistory whistory
			JOIN whistory.team team
			JOIN whistory.startSemester startSemester
			LEFT JOIN whistory.endSemester endSemester
			WHERE (startSemester.semesterStartDate < :today
			AND endSemester.semesterEndDate > :today)
			OR (startSemester.semesterStartDate < :today
			AND endSemester.semesterEndDate is NULL)
			OR (startSemester.semesterStartDate < :today
			AND endSemester.semesterEndDate < :today)
			AND team.department = :department

			")
			->setParameter('today', $today)
			->setParameter('department', $department)
			->getResult();

		return $workHistories;
	}



}
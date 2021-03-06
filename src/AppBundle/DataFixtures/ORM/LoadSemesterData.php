<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Semester;

class LoadSemesterData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $now = new \DateTime();
        $jan = 1;
        $jul = 7;
        $aug = 8;
        $dec = 12;
        $isSpring = $now->format('n') <= $jul;

        $semester1 = new Semester();
        $semester1->setSemesterTime('Vår');
        $semester1->setYear(2013);
        $semester1->setDepartment($this->getReference('dep-1'));
        $semester1->setAdmissionStartDate(new \DateTime('2013-01-01'));
        $semester1->setAdmissionEndDate(new \DateTime('2013-01-05'));
        $semester1->setSemesterStartDate(new \DateTime('2013-01-01'));
        $semester1->setSemesterEndDate(new \DateTime('2013-07-31'));
        $manager->persist($semester1);

        $currentSemester = new Semester();
        $currentSemester->setSemesterTime($now->format('n') <= 7 ? 'Vår' : 'Høst');
        $currentSemester->setYear($now->format('Y'));
        $currentSemester->setDepartment($this->getReference('dep-1'));
        $currentSemester->setAdmissionStartDate(new \DateTime());
        $currentSemester->setAdmissionEndDate(new \DateTime());
        $currentSemester->setSemesterStartDate(new \DateTime());
        $currentSemester->setSemesterEndDate(new \DateTime());
        $currentSemester->getSemesterStartDate()->setDate($currentSemester->getYear(), $isSpring ? $jan : $aug, 1);
        $currentSemester->getSemesterEndDate()->setDate($currentSemester->getYear(), $isSpring ? $jul : $dec, 31);
        $currentSemester->getAdmissionStartDate()->modify('-1day');
        $currentSemester->getAdmissionEndDate()->modify('+1day');
        $manager->persist($currentSemester);

        $previousSemester = new Semester();
        $previousSemester->setSemesterTime($isSpring ? 'Høst' : 'Vår');
        $previousSemester->setYear($isSpring ? $now->format('Y') - 1 : $now->format('Y'));
        $previousSemester->setDepartment($this->getReference('dep-1'));
        $previousSemester->setAdmissionStartDate(new \DateTime());
        $previousSemester->setAdmissionEndDate(new \DateTime());
        $previousSemester->setSemesterStartDate(new \DateTime());
        $previousSemester->setSemesterEndDate(new \DateTime());
        $previousSemester->getSemesterStartDate()->setDate($previousSemester->getYear(), $isSpring ? $aug : $jan, 1);
        $previousSemester->getSemesterEndDate()->setDate($previousSemester->getYear(), $isSpring ? $dec : $jul, 31);
        $previousSemester->getAdmissionStartDate()->setDate($previousSemester->getYear(), $isSpring ? $aug : $jan, 1);
        $previousSemester->getAdmissionEndDate()->setDate($previousSemester->getYear(), $isSpring ? $aug : $jan, 5);
        $manager->persist($previousSemester);

        $semester2 = new Semester();
        $semester2->setSemesterTime('Vår');
        $semester2->setYear(2015);
        $semester2->setDepartment($this->getReference('dep-2'));
        $semester2->setAdmissionStartDate(new \DateTime('2015-01-01'));
        $semester2->setAdmissionEndDate(new \DateTime('2015-05-30'));
        $semester2->setSemesterStartDate(new \DateTime('2015-01-01'));
        $semester2->setSemesterEndDate(new \DateTime('2015-07-31'));
        $manager->persist($semester2);

        $semester3 = new Semester();
        $semester3->setSemesterTime('Vår');
        $semester3->setYear(2015);
        $semester3->setDepartment($this->getReference('dep-3'));
        $semester3->setAdmissionStartDate(new \DateTime('2015-01-01'));
        $semester3->setAdmissionEndDate(new \DateTime('2015-05-30'));
        $semester3->setSemesterStartDate(new \DateTime('2015-01-01'));
        $semester3->setSemesterEndDate(new \DateTime('2015-07-31'));
        $manager->persist($semester3);

        $semester4 = new Semester();
        $semester4->setSemesterTime('Vår');
        $semester4->setYear(2015);
        $semester4->setDepartment($this->getReference('dep-4'));
        $semester4->setAdmissionStartDate(new \DateTime('2015-01-01'));
        $semester4->setAdmissionEndDate(new \DateTime('2015-05-30'));
        $semester4->setSemesterStartDate(new \DateTime('2015-01-01'));
        $semester4->setSemesterEndDate(new \DateTime('2015-07-31'));
        $manager->persist($semester4);

        $semester5 = new Semester();
        $semester5->setSemesterTime('Høst');
        $semester5->setYear(2015);
        $semester5->setDepartment($this->getReference('dep-1'));
        $semester5->setAdmissionStartDate(new \DateTime('2014-08-01'));
        $semester5->setAdmissionEndDate(new \DateTime('2014-12-30'));
        $semester5->setSemesterStartDate(new \DateTime('2014-08-01'));
        $semester5->setSemesterEndDate(new \DateTime('2014-12-31'));
        $manager->persist($semester5);

        $manager->flush();

        $this->addReference('semester-1', $semester1);
        $this->addReference('semester-2', $semester2);
        $this->addReference('semester-3', $semester3);
        $this->addReference('semester-4', $semester4);
        $this->addReference('semester-5', $semester5);
        $this->addReference('semester-current', $currentSemester);
        $this->addReference('semester-previous', $previousSemester);
    }

    public function getOrder()
    {
        return 3;
    }
}

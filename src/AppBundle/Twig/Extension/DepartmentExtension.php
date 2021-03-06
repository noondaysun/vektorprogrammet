<?php

namespace AppBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;

class DepartmentExtension extends \Twig_Extension
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getName()
    {
        return 'department_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_departments', array($this, 'getDepartments')),
        );
    }

    public function getDepartments()
    {
        return $this->em->getRepository('AppBundle:Department')->findAll();
    }
}

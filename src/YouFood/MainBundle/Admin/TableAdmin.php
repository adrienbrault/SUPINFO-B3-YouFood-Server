<?php

namespace YouFood\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * TableAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class TableAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('id')
            ->add('name')
            ->add('zone')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('required' => false))
        ;
    }
}
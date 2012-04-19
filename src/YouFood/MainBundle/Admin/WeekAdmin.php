<?php

namespace YouFood\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * WeekAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class WeekAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('year')
            ->add('weekNumber')
            ->add('dateStart', 'datetime')
            ->add('dateEnd', 'datetime')
            ->add('theme')

        // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('year')
            ->add('weekNumber')
            ->add('dateStart', 'datetime')
            ->add('dateEnd', 'datetime')
            ->add('theme')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('year')
            ->add('weekNumber')
            ->add('theme', null, array('empty_value' => 'No theme', 'required' => false))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('year')
            ->add('weekNumber')
        ;
    }
}
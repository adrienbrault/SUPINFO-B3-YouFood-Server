<?php

namespace YouFood\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * MenuOrderAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class MenuOrderAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('menu')
            ->add('price')

        // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
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
            ->add('id')
            ->add('menu')
            ->add('price')
            ->add('collations')
        ;
    }
}
<?php

namespace YouFood\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * AccessTokenAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class AccessTokenAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('token')
            ->add('expiresAt', 'date')
            ->add('notExpired', 'boolean')
            ->add('client')
            ->add('user')

            ->add('_action', 'actions', array(
                'actions' => array(
                    'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
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
            ->add('token')
            ->add('expiresAt', 'date')
            ->add('notExpired', 'boolean')
            ->add('client')
            ->add('user')
            ->add('scope')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('token')
            ->add('client')
            ->add('user', null, array('required' => 'false', 'empty_value' => ''))
            ->add('expiresAt')
            ->add('scope')
        ;
    }
}
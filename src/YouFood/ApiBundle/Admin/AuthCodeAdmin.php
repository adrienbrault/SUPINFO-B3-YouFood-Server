<?php

namespace YouFood\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * AuthCodeAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class AuthCodeAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('token')
            ->add('client')
            ->add('user')
            ->add('redirectUri')
            ->add('expiresAt')
            ->add('scope')

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
            ->add('client')
            ->add('user')
            ->add('redirectUri')
            ->add('expiresAt')
            ->add('scope')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('client')
            ->add('user')
            ->add('redirectUri')
            ->add('expiresAt')
            ->add('scope')
        ;
    }
}

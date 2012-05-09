<?php

namespace YouFood\ApiBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use OAuth2\OAuth2;

/**
 * ClientAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class ClientAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('redirectUris')
            ->add('allowedGrantTypes')

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
            ->add('randomId')
            ->add('secret')
            ->add('name')
            ->add('redirectUris', 'array')
            ->add('allowedGrantTypes', 'array')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('allowedGrantTypes', 'choice', array(
                'choices' => array(
                    OAuth2::GRANT_TYPE_AUTH_CODE => OAuth2::GRANT_TYPE_AUTH_CODE,
                    OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS => OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS,
                    OAuth2::GRANT_TYPE_EXTENSIONS => OAuth2::GRANT_TYPE_EXTENSIONS,
                    OAuth2::GRANT_TYPE_IMPLICIT => OAuth2::GRANT_TYPE_IMPLICIT,
                    OAuth2::GRANT_TYPE_REFRESH_TOKEN => OAuth2::GRANT_TYPE_REFRESH_TOKEN,
                    OAuth2::GRANT_TYPE_USER_CREDENTIALS => OAuth2::GRANT_TYPE_USER_CREDENTIALS,
                ),
                'multiple' => true,
                'expanded' => true,
            ))
        ;
    }
}

<?php

namespace YouFood\MainBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * MenuCollationAdmin
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class MenuCollationAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('collation', 'sonata_type_model', array(), array('edit' => 'list'))
            ->add('position')
        ;
    }
}
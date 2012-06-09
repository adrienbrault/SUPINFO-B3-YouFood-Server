<?php

namespace YouFood\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * OrderType
 *
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class OrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('collations', 'entity', array(
            'class' => 'YouFoodMainBundle:Collation',
            'multiple' => true,
        ));
        $builder->add('menus', 'entity', array(
            'class' => 'YouFoodMainBundle:Menu',
            'multiple' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions()
    {
        return array(
            'csrf_protection' => false,
        );
    }
}

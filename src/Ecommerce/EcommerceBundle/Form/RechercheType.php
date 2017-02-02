<?php

namespace Ecommerce\EcommerceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('recherche',TextType::class,['attr' => ['label' => false,
                                                    'class' => 'input-medium search-query',
                                              'placeholder' => 'Rechercher'
                ]])
                ->setMethod('POST');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'intention' => 'search',
        ));
    }

    public function getName()
    {
        return 'ecommerce_bundle_recherche_type';
    }
}

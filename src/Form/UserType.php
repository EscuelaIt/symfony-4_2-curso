<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password', PasswordType::class)
        ;

        $builder->get('roles')
            ->addViewTransformer( new CallbackTransformer(
                function( array $rolesAsArray ) {
                    return implode(',', $rolesAsArray );
                },
                function( string $rolesAsString ) {
                    return explode( ',', $rolesAsString );
                }
            ) );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

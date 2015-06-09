<?php

namespace Pesh\PortfolioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
                'attr' => array(
                    'placeholder' => 'Votre nom',
                    'pattern'     => '.{2,}'
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Votre Email.'
                )
            ))
            ->add('sujet', 'text', array(
                'attr' => array(
                    'placeholder' => 'Sujet du message.',
                    'pattern'     => '.{3,}'
                )
            ))
            ->add('message', 'textarea', array(
                'attr' => array(
                    // 'cols' => 90,
                    // 'rows' => 10,
                    'placeholder' => 'Votre message...'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'nom' => array(
                new NotBlank(array('message' => 'Le nom est vide.')),
                new Length(array('min' => 2))
            ),
            'email' => array(
                new NotBlank(array('message' => 'L\'email est vide.')),
                new Email(array('message' => 'Adresse non-valide.'))
            ),
            'sujet' => array(
                new NotBlank(array('message' => 'Le sujet est vide.')),
                new Length(array('min' => 3))
            ),
            'message' => array(
                new NotBlank(array('message' => 'Le message est vide.')),
                new Length(array('min' => 5))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}
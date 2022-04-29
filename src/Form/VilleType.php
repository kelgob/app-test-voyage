<?php

namespace App\Form;

use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Ville::class,
            'query_builder' => fn(EntityRepository $er) => $er->createQueryBuilder('v')->orderBy('v.name', 'ASC'),
        ]);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}

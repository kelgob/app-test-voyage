<?php

namespace App\Form;

use App\Entity\Etape;
use App\Entity\Ville;
use App\Util\ChoiceList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', ChoiceType::class, [
            'choices' => ChoiceList::getEtapeTypes(),
            'choice_label' => fn($choice, $key, $value) => "etape.type.$value",
            'expanded' => true,
            'label' => false,
            'label_attr' => [
                'class' => 'radio-inline',
            ],
        ]);

        $builder->add('number');
        $builder->add('seat');
        $builder->add('gate');
        $builder->add('baggageDrop');
        $builder->add('departure', VilleType::class);
        $builder->add('arrival', VilleType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etape::class,
        ]);
    }
}

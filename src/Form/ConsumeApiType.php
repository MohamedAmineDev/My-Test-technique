<?php
/**
 * Ce fichier fait partie du projet mon-test-technique
 *
 * Dans le cas où le fichier est complexe ou important, ne pas hésiter à donner des détails ici…
 *
 * @package Form
 * @copyright 2023 Quantic Factory
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Cette classe  permet de créer un formulaire pour la consommation d'un api externe
 *
 * @author Mohamed Amine Ben Safta <mohamedaminebensafta[@]gmail.com>
 */

class ConsumeApiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('apiUrl', UrlType::class, ['label' => 'Api url', 'required' => true, 'attr' => ['minlength' => 5, 'placeholder' => 'https://exemple.com']])
            ->add('apiKey', PasswordType::class, ['label' => 'Api key', 'required' => true, 'attr' => ['minlength' => 5, 'placeholder' => 'xxxxxxxxxx']])
            ->add('submit', SubmitType::class, ['label' => 'Submit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

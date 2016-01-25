<?php
namespace Fsv\TypographyBundle\Form\Extension;

use Fsv\TypographyBundle\Form\DataTransformer\TypographyTransformer;
use Fsv\TypographyBundle\Typograph\TypographMapInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaTypeExtension extends AbstractTypeExtension
{
    /**
     * @var TypographMapInterface
     */
    private $typographMap;

    /**
     * @param TypographMapInterface $typographMap
     */
    public function __construct(TypographMapInterface $typographMap)
    {
        $this->typographMap = $typographMap;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return method_exists(FormTypeInterface::class, 'getBlockPrefix')
            ? TextareaType::class
            : 'textarea'
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['typography']) {
            $builder->addModelTransformer(
                new TypographyTransformer(
                    $this->typographMap->getTypograph($options['typography'])
                )
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('typography', false);
    }
}

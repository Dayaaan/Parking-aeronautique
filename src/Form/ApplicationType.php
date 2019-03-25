<?php 
namespace App\Form;
use App\Entity\Advantage;
use Symfony\Component\Form\AbstractType;
//ApplicationType permet d'alléger le code de nos formulaires 
class ApplicationType extends AbstractType {
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    protected function getConfiguration($label,$placeholder, $options = [] ) {
        return array_merge_recursive([
            'label' => $label,
                'attr' => [
                    'placeholder' => $placeholder
                ]
        ], $options);
    }
}
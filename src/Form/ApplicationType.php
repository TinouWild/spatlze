<?php
/**
 * Created by PhpStorm.
 * User: etienne
 * Date: 05/12/18
 * Time: 11:17
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    /**
     * @param $placeholder
     * @return array
     */
    protected function getConfiguration($placeholder)
    {
        return [
            'label' => false,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }
}
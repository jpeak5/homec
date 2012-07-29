<?php

namespace Piquage\BillsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of BillerType
 *
 * @author jpeak5
 */
class BillerType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('name');
        $builder->add('website');
    }

    public function getName() {
        return 'biller';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Piquage\BillsBundle\Entity\Biller',
        );
    }

}

?>

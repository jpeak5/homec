<?php

namespace Piquage\BillsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of BillType
 *
 * @author jpeak5
 */
class BillType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('due');
        $builder->add('scheduled');
        $builder->add('paid');
        $builder->add('cleared');
        $builder->add('confNumber');
        $builder->add('billTemplate');
        $builder->add('amount');
    }

    public function getName() {
        return 'bill';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Piquage\BillsBundle\Entity\Bill',
        );
    }

}

?>

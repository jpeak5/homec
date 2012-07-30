<?php

namespace Piquage\BillsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of BillTemplateType
 *
 * @author jpeak5
 */
class BillTemplateType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('nickname');
        $builder->add('biller');
        $builder->add('active');
        $builder->add('recurrenceType');
        $builder->add('recurrenceDay');
        $builder->add('autoDebit');
        $builder->add('avgAmount');
    }

    public function getName() {
        return 'billTemplate';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'Piquage\BillsBundle\Entity\BillTemplate',
        );
    }

}

?>

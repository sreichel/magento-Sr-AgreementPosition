<?php

class Sr_AgreementPosition_Model_Observer
{
    /**
     * Add "Postion" to Checkout Agreements
     */
    public function addAgreementsPosition(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block instanceof Mage_Adminhtml_Block_Checkout_Agreement_Edit_Form) {
            $helper = Mage::helper('sr_agreement');
            $form = $block->getForm();

            $form->getElement('content')->setRequired(false);

            /** @var Varien_Data_Form_Element_Fieldset $fieldset */
            $fieldset = $form->getElement('base_fieldset');

            $fieldset->addField('position', 'text', array(
                'label'    => $helper->__('Position'),
                'title'    => $helper->__('Position'),
                'name'     => 'position',
                'value'    => '0',
                'required' => true,
                'class'    => 'validate-zero-or-greater',
            ));

            $model = Mage::registry('checkout_agreement');
            $form->setValues($model->getData());
            $block->setForm($form);
        }

        return $this;
    }

    /**
     * Sort agreements
     */
    public function sortAgreements(Varien_Event_Observer $observer)
    {
        $block = $observer->getEvent()->getBlock();
        if ($block->getType() == 'checkout/agreements') {
            if ($agreements = $block->getAgreements()) {
                $agreements->setOrder('position', Varien_Data_Collection::SORT_ORDER_ASC);

                $collection = new Varien_Data_Collection();
                foreach ($agreements as $agreement) {
                    $collection->addItem($agreement);
                }
                $observer->getEvent()->getBlock()->setAgreements($collection);
            }
        }

        return $this;
    }
}

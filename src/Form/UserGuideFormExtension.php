<?php

namespace Norvutec\UserGuideBundle\Form;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGuideFormExtension extends AbstractTypeExtension {

    public const USER_GUIDE = 'user_guide';
    public const USER_GUIDE_STEP = 'user_guide_step';

    public function __construct() {
    }

    public static function getExtendedTypes(): iterable {
        return [FormType::class];
    }

    public function configureOptions(OptionsResolver $resolver) : void {
        $resolver->setDefined([self::USER_GUIDE, 'user_guide_step']);
        $resolver->setAllowedTypes(self::USER_GUIDE, ['string', 'null']);
        $resolver->setAllowedTypes(self::USER_GUIDE_STEP, ['int', 'null']);
        $resolver->setDefault(self::USER_GUIDE, null);
        $resolver->setDefault(self::USER_GUIDE_STEP, null);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void {
        if(!in_array(self::USER_GUIDE, $options) || $options[self::USER_GUIDE] == null) {
            return;
        }
        if(!in_array('attr', $view->vars)) {
            $view->vars['attr'] = [];
        }
        if(!in_array('label_attr', $view->vars)) {
            $view->vars['label_attr'] = [];
        }
        $view->vars['attr']['data-assigned-user-guide'] = $options[self::USER_GUIDE];
        $view->vars['label_attr']['data-assigned-user-guide'] = $options[self::USER_GUIDE];
        if($options[self::USER_GUIDE_STEP] != null) {
            $view->vars['attr']['data-assigned-user-guide-step'] = $options[self::USER_GUIDE_STEP];
            $view->vars['label_attr']['data-assigned-user-guide-step'] = $options[self::USER_GUIDE_STEP];
        }
    }

}
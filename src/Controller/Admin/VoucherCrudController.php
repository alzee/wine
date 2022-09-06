<?php

namespace App\Controller\Admin;

use App\Entity\Voucher;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class VoucherCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Voucher::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $types = [
            '代理商-请货' => 0,
            '门店-请货' => 1,
            '总公司-代理商退货' => 2,
            '代理商-门店退货' => 3,
            '总公司-代理商提现' => 4,
            '代理商-门店提现' => 5,
            '餐厅-顾客消费' => 6,
            '代理商-出货' => 10,
            '门店-出货' => 11,
            '代理商退货' => 12,
            '门店退货' => 13,
            '代理商-提现' => 14,
            '门店-提现' => 15,
            '顾客-餐厅消费' => 16,
            '内部调控' => 30,
        ];

        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('org'),
            MoneyField::new('voucher')->setCurrency('CNY'),
            ChoiceField::new('type')->setChoices($types),
            DateTimeField::new('date')->HideOnForm(),
        ];
    }
}

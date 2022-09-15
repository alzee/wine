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
use Doctrine\ORM\QueryBuilder;

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
            '顾客-门店购物' => 7,
            '总公司-代理商请货' => 10,
            '代理商-门店请货' => 11,
            '代理商-退货' => 12,
            '门店-退货' => 13,
            '代理商-提现' => 14,
            '门店-提现' => 15,
            '顾客-餐厅消费' => 16,
            '门店-销售' => 17,
            '内部调控' => 30,
        ];

        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('org')->onlyOnIndex(),
            AssociationField::new('org')->onlyOnForms()->setQueryBuilder (
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type <= 3')->andWhere('entity.type != 0')
            ),
            AssociationField::new('consumer')->onlyOnIndex(),
            MoneyField::new('voucher')->setCurrency('CNY'),
            ChoiceField::new('type')->setChoices($types)->HideWhenCreating(),
            ChoiceField::new('type')->setChoices(['内部调控' => 30])->onlyWhenCreating(),
            TextField::new('note'),
            DateTimeField::new('date')->HideOnForm(),
        ];
    }
}

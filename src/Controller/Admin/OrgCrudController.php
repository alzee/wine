<?php

namespace App\Controller\Admin;

use App\Entity\Org;
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
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;

class OrgCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Org::class;
    }
    public function configureFields(string $pageName): iterable
    {
        // If current editing entity's type == 2 (store)
        if (1) {
            $isHidden = '';
        } else {
            $isHidden = 'd-none';
        }
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('contact'),
            TelephoneField::new('phone'),
            TextField::new('address'),
            TextField::new('district'),
            ChoiceField::new('type')->setChoices(['Head' => 0, 'Agency' => 1, 'Store' => 2, 'Restaurant' => 3, 'Consumer' => 4])->hideWhenCreating(),
            ChoiceField::new('type')->setChoices(['Agency' => 1, 'Store' => 2, 'Restaurant' => 3])->onlyWhenCreating(),
            AssociationField::new('upstream')->setQueryBuilder(
                fn (QueryBuilder $qb) => $qb->andWhere('entity.type = :type')->setParameter('type', 1)
            )->onlyOnForms()->addCssClass("upstream $isHidden"),
            MoneyField::new('voucher')->setCurrency('CNY'),
        ];
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addJsFile('js/z.js')
        ;
    }
}

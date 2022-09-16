<?php

namespace App\Controller\Admin;

use App\Entity\Withdraw;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class WithdrawCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Withdraw::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('applicant')
                ->HideWhenCreating()
                ->setFormTypeOptions(['disabled' => 'disabled']),
            AssociationField::new('applicant')
                ->onlyWhenCreating()
                ->setQueryBuilder (
                    fn (QueryBuilder $qb) => $qb
                        ->andWhere('entity.id = :id')
                        ->setParameter('id', $this->getUser()
                        ->getOrg())
            ),
            AssociationField::new('approver')
                ->HideWhenCreating()
                ->setFormTypeOptions(['disabled' => 'disabled']),
            AssociationField::new('approver')
                ->onlyWhenCreating()
                ->setQueryBuilder (
                    fn (QueryBuilder $qb) => $qb
                        ->andWhere('entity.id = :id')
                        ->setParameter('id', $this->getUser()
                        ->getOrg()
                        ->getUpstream())
            ),
            MoneyField::new('amount')
                ->setCurrency('CNY')
                ->HideWhenCreating()
                ->setFormTypeOptions(['disabled' => 'disabled']),
            MoneyField::new('amount')
                ->setCurrency('CNY')
                ->onlyWhenCreating(),
            PercentField::new('discount'),
            ChoiceField::new('status')
                ->HideWhenCreating()
                ->setChoices(['Pending' => 0, 'Rejected' => 4, 'Success' => 5]),
            DateTimeField::new('date')->HideOnForm(),
            TextareaField::new('note'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE)
            ;
        }
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if ($this->isGranted('ROLE_HEAD')) {
            $response->andWhere("entity.approver = $userOrg");
        } else {
            $response
                ->andWhere("entity.applicant = $userOrg")
                ->orWhere("entity.approver = $userOrg");
        }
        return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $help = '<b>申请方</b>为当前登录机构。<br/>只有<b>餐厅</b>和<b>代理商</b>可以发起申请。<br/><b>餐厅</b>提交申请由<b>代理商</b>审核。<br/><b>代理商</b>提交申请由<b>总公司</b>审核。';
        return $crud
            ->setDefaultSort(['id' => 'DESC'])
            ->setHelp('index', $help)
            ->setHelp('new', $help)
        ;
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Returns;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ReturnsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Returns::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $user = $this->getUser();
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('sender')
                ->setQueryBuilder(
                    fn (QueryBuilder $qb) => $qb
                        ->andWhere('entity.upstream = :userOrg')
                        ->andWhere('entity.type != 3')
                        ->setParameter('userOrg', $user->getOrg())
                ),
            AssociationField::new('recipient')
                ->setQueryBuilder(
                    fn (QueryBuilder $qb) => $qb->andWhere('entity.id = :id')->setParameter('id', $user->getOrg())
                ),
            CollectionField::new('returnItems')
                ->OnlyOnForms()
                ->setFormTypeOptions(['required' => 'required'])
                ->useEntryCrudForm(),
            MoneyField::new('amount')
                ->setCurrency('CNY')
                ->onlyOnIndex(),
            MoneyField::new('voucher')
                ->setCurrency('CNY')
                ->onlyOnIndex(),
            ChoiceField::new('status')
                ->setChoices(['Pending' => 0, 'Success' => 5])
                ->hideWhenCreating(),
            DateTimeField::new('date')->HideOnForm(),
            TextareaField::new('note'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere("entity.sender = $userOrg")->orWhere("entity.recipient = $userOrg");
        return $response;
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_STORE') || $this->isGranted('ROLE_RESTAURANT')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE)
            ;
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        $help = '退货由<b>接收方</b>创建。<br/><b>接收方</b>为当前登录机构，<b>退货方</b>为本机构下级。<br/>退货创建后默认为<b>待处理</b>状态，请检查并审核。';
        return $crud->setHelp('new', $help);
    }
}

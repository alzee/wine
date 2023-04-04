<?php

namespace App\Controller\Admin;

use App\Entity\Settle;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DatetimeField;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use App\Filter\Admin\AgencyFilter;
use Doctrine\ORM\EntityRepository as ER;

class SettleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Settle::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('salesman.agency');
        yield AssociationField::new('salesman');
        yield AssociationField::new('claim');
        yield AssociationField::new('product');
        yield ChoiceField::new('type')
            ->setChoices(Choice::SETTLE_TYPES)
        ;
        yield ChoiceField::new('status')
            ->setChoices(Choice::SETTLE_STATUSES)
        ;
        yield BooleanField::new('delivered')
            ->renderAsSwitch(false)
            // ->setDisabled(true)
        ;
        yield DatetimeField::new('createdAt');
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $deliver = Action::new('deliver')
            ->linkToCrudAction('deliver')
            ->addCssClass('btn btn-primary')
            ->setIcon('fa fa-send')
        ;
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::DETAIL)
                ->remove('index', Action::EDIT)
                ->addBatchAction($deliver)
            ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL)
            ;
        }
    }
    
    public function deliver(BatchActionDto $batchActionDto)
    {
        $className = $batchActionDto->getEntityFqcn();
        $entityManager = $this->container->get('doctrine')->getManagerForClass($className);
        foreach ($batchActionDto->getEntityIds() as $id) {
            $settle = $entityManager->find($className, $id);
            $settle->setDelivered(true);
        }

        $entityManager->flush();

        return $this->redirect($batchActionDto->getReferrerUrl());
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        $f = AgencyFilter::new('salesman', 'Agency')
            ->setFormTypeOption('value_type_options.class', 'App\Entity\Org')
            ->setFormTypeOption(
                'value_type_options.query_builder',
                static fn(ER $rep) => $rep
                    ->createQueryBuilder('o')
                    ->andWhere('o.type = 1 OR o.type = 11')
                )
            ;
        return $filters
            ->add($f)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setSearchFields(null)
        ;
    }
}

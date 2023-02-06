<?php

namespace App\Controller\Admin;

use App\Entity\Share;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;

class ShareCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Share::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if ($this->isGranted('ROLE_HEAD')) {
            yield IdField::new('id')->onlyOnIndex();
        }
        yield ChoiceField::new('type')
            ->setChoices(Choice::SHARE_TYPES);
        yield MoneyField::new('amount')
                ->setCurrency('CNY')
            ;
        if ($this->isGranted('ROLE_HEAD')) {
            yield AssociationField::new('org');
        }
        yield AssociationField::new('retail');
        yield ChoiceField::new('status')
            ->setChoices(Choice::REWARD_SHARE_STATUSES);
        yield DateTimeField::new('createdAt');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::EDIT, Action::NEW, Action::DETAIL)
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrgId = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (! $this->isGranted('ROLE_HEAD')) {
            $response->andWhere("entity.org = $userOrgId");
        }
        return $response;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural%明细')
            ->overrideTemplates([ 'crud/index' => 'admin/pages/index.html.twig', ])
        ;
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
      if (!$this->isGranted('ROLE_HEAD')) {
        if (Crud::PAGE_INDEX === $responseParameters->get('pageName')) {
          $share = $this->getuser()->getOrg()->getShare() / 100;
          $responseParameters->set('share', $share);
          ;
        }
      }
      return $responseParameters;
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Bottle;
use App\Entity\Box;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use App\Entity\Choice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;

class BottleCrudController extends AbstractCrudController
{
    private RequestStack $requestStack;
    private $boxid;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
        $request = $this->requestStack->getCurrentRequest();
        $this->boxid = $request->query->get('box');
    }

    public static function getEntityFqcn(): string
    {
        return Bottle::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $instance = $this->getContext()->getEntity()->getInstance();

        yield AssociationField::new('box')
            ->onlyOnIndex()
            ;
        yield AssociationField::new('box')
            ->hideOnIndex()
            ->setDisabled()
            ;
        yield TextField::new('sn', 'bottle.sn')
            ->onlyOnIndex()
            ;
        yield TextField::new('sn', 'bottle.sn')
            ->hideOnIndex()
            ->setDisabled()
            ;
        yield TextField::new('cipher')
            ->onlyOnIndex()
            ->setMaxLength(25)
            ->hideWhenCreating()
            ;
        yield TextField::new('cipher')
            ->hideOnIndex()
            ->setDisabled()
            ;
        if ($pageName === 'edit' && $instance->getStatus() > 0) {
            yield AssociationField::new('prize')
                ->setDisabled()
                ;
        } else {
            yield AssociationField::new('prize');
        }
        yield ChoiceField::new('status')
            ->onlyOnIndex()
            ->setChoices(Choice::BOTTLE_STATUSES);
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE, Action::DETAIL, Action::NEW)
        ;
    }
    
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        if (! is_null($this->boxid)) {
            $response->andWhere("entity.box = $this->boxid");
        }
        return $response;
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Node;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Admin\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class FeaturedCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Node::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        if ($this->isGranted('ROLE_HEAD')) {
            yield AssociationField::new('product')
                ->setRequired(true)
            ;
        }
        yield ImageField::new('img')
            ->onlyOnIndex()
            ->setBasePath('img/node/thumbnail/')
            // ->setUploadDir('public/img/node/')
        ;
        yield VichImageField::new('imageFile', 'Img')
            ->hideOnIndex()
            ;
        yield TextareaField::new('body')
            ->onlyOnForms()
            // ->addCssClass('test')
            ;
        yield DateTimeField::new('date')
            ->onlyOnIndex();
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addJsFile(
                Asset::new('/js/ckeditor.js')
                    ->onlyOnForms()
            )
            ->addJsFile(
                Asset::new('/js/initCKEditor.js')
                    ->defer()
                    ->onlyOnForms()
            )
        ;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $userOrg = $this->getUser()->getOrg()->getId();
        $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response
            ->andWhere("entity.org = $userOrg")
            ->andWhere("entity.tags LIKE '%1%'")
        ;
        return $response;
    }

    public function createEntity(string $entityFqcn)
    {
        $node = new Node();
        $node->setOrg($this->getUser()->getOrg());
        $node->setTags([1]);

        return $node;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $title = 'Featured';
        return $crud
            ->setPageTitle('index', $title)
            ->setPageTitle('new', 'Add ' . $title)
            ->setPageTitle('edit', 'Edit ' . $title)
        ;
    }
}

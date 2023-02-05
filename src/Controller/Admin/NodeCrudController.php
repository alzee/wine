<?php

namespace App\Controller\Admin;

use App\Entity\Node;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
// use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use App\Admin\Field\VichImageField;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class NodeCrudController extends AbstractCrudController
{
    private $tags = [
        '轮播图' => 0,
        // '产品推荐' => 1,
        '企业简介' => 2,
        '用户协议' => 3,
        '活动公告' => 4,
        '滚动信息' => 5,
    ];

    public static function getEntityFqcn(): string
    {
        return Node::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // yield IdField::new('id')
        //     ->onlyOnIndex();
        yield TextField::new('title');
        yield ImageField::new('img')
            ->onlyOnIndex()
            ->setBasePath('img/node/thumbnail/')
            // ->setUploadDir('public/img/node/')
        ;
        yield VichImageField::new('imageFile', 'Img')
            ->hideOnIndex()
            ;
        if ($this->isGranted('ROLE_HEAD')) {
            yield ChoiceField::new('tags')
                ->setChoices($this->tags)
                ->allowMultipleChoices()
            ;
        }
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
            ->andWhere("entity.tags != 1")
        ;
        return $response;
    }

    public function createEntity(string $entityFqcn)
    {
        $node = new Node();
        $node->setOrg($this->getUser()->getOrg());

        return $node;
    }
}

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

class NodeCrudController extends AbstractCrudController
{
    private $tags = ['轮播图' => 0, '产品推荐' => 1, '企业简介' => 2, '用户协议' => 3];

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
        yield ChoiceField::new('tag')
            ->setChoices($this->tags)
            // ->allowMultipleChoices()
        ;
        yield TextareaField::new('body')
            ->onlyOnForms()
            // ->addCssClass('test')
            ;
        yield DateTimeField::new('date')
            ->onlyOnIndex();
    }

    public function configureActions(Actions $actions): Actions
    {
        if ($this->isGranted('ROLE_HEAD')) {
            return $actions
                ;
        } else {
            return $actions
                ->disable(Action::DELETE, Action::NEW, Action::EDIT, Action::DETAIL, Action::INDEX)
            ;
        }
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
}

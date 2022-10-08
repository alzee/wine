<?php

namespace App\Controller\Admin;

use App\Entity\Node;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
// use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NodeCrudController extends AbstractCrudController
{
    private $tags = ['轮播图' => 0, '推荐' => 1, '企业简介' => 2];

    public static function getEntityFqcn(): string
    {
        return Node::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->onlyOnIndex();
        yield TextField::new('title');
        yield ImageField::new('img')
            ->onlyOnIndex()
            ->setBasePath('img/node/')
            ->setUploadDir('public/img/node/');
        yield TextField::new('imageFile')
            ->hideOnIndex()
            ->setFormType(VichImageType::class)
            ->setFormTypeOptions(['allow_delete' => false])
            ;
        yield ChoiceField::new('tag')
            ->setChoices($this->tags)
            // ->allowMultipleChoices()
        ;
        yield TextEditorField::new('body')
            ->hideOnIndex();
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
}

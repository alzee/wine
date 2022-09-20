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

class NodeCrudController extends AbstractCrudController
{
    private $tags = ['推荐1' => 0, '推荐2' => 1, '推荐3' => 2];

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
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads/');
        yield ChoiceField::new('tag')
            ->setChoices($this->tags)
            // ->allowMultipleChoices()
        ;
        yield TextEditorField::new('body')
            ->hideOnIndex();
        yield DateTimeField::new('date')
            ->onlyOnIndex();
    }
}

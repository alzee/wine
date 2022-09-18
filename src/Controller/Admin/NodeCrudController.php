<?php

namespace App\Controller\Admin;

use App\Entity\Node;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DatetimeField;

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
        yield ChoiceField::new('tag')
            ->setChoices($this->tags)
            // ->allowMultipleChoices()
        ;
        yield TextEditorField::new('body')
            ->hideOnIndex();
        yield DatetimeField::new('date')
            ->onlyOnIndex();
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Batch;
use App\Entity\BatchPrize;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class BatchCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Batch::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'box.id')
            ->hideOnForm()
        ;
        yield IntegerField::new('qty')
            // ->onlyWhenCreating()
        ;
        yield TextField::new('snStart')
            ->hideWhenCreating()
        ;
        yield TextField::new('snEnd')
            ->hideWhenCreating()
        ;
        yield IntegerField::new('bottleQty');
        yield CollectionField::new('batchPrizes')
            ->hideOnIndex()
            // ->allowAdd(false)
            // ->allowDelete(false)
            ->renderExpanded()
            ->setRequired(true)
            ->useEntryCrudForm()
        ;
        yield ArrayField::new('batchPrizes')
            ->onlyOnIndex()
        ;
    }

    public function createEntity(string $entityFqcn)
    {
        $batch = new Batch();
        $item = new BatchPrize();
        $batch->addBatchPrize($item);

        return $batch;
    }
}

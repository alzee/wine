<?php
/**
 * vim:ft=php et ts=4 sts=4
 * @author Al Zee <z@alz.ee>
 * @version
 * @todo
 */

namespace App\Filter\Admin;

use App\Form\Admin\AgencyFilterType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use EasyCorp\Bundle\EasyAdminBundle\Form\Filter\Type\EntityFilterType;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\ComparisonType;

class AgencyFilter implements FilterInterface
{
    use FilterTrait;
    
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(EntityFilterType::class)
            ->setFormTypeOption('translation_domain', 'EasyAdminBundle')
        ;
    }
    
    public function apply(QueryBuilder $queryBuilder, FilterDataDto $filterDataDto, ?FieldDto $fieldDto, EntityDto $entityDto): void
    {
        $alias = $filterDataDto->getEntityAlias();
        $comparison = $filterDataDto->getComparison();
        $value = $filterDataDto->getValue();
        
        $queryBuilder
            ->leftJoin($alias . '.salesman', 's')
            ->leftJoin('s.org', 'o')
            ->leftJoin('o.upstream', 'a')
            ->setParameter('agency', $value)
        ;
        if (ComparisonType::NEQ === $comparison) {
            $queryBuilder
                ->andWhere('a != :agency')
            ;
        }
        $queryBuilder
            ->andWhere('a = :agency')
        ;
    }
}

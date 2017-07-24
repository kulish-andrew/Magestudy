<?php

namespace Magestudy\Crud\Controller\Adminhtml\Category;

use Magestudy\Crud\Api\CategoryRepositoryInterface;
use Magestudy\Crud\Controller\Adminhtml\AbstractMassDisable;
use Magestudy\Crud\Helper\AclResources;
use Magestudy\Crud\Model\Category;
use Magestudy\Crud\Model\ResourceModel\Category\Collection as CategoryCollection;

class MassDisable extends AbstractMassDisable
{
    /**
     * @return string
     */
    protected function _getAclResource()
    {
        return AclResources::CATEGORY_SAVE;
    }

    /**
     * @return string
     */
    protected function _getEntityTitle()
    {
        return Category::ENTITY_TITLE;
    }

    /**
     * @return string
     */
    protected function _getCollectionClass()
    {
        return CategoryCollection::class;
    }

    /**
     * @return string
     */
    protected function _getRepositoryClass()
    {
        return CategoryRepositoryInterface::class;
    }
}
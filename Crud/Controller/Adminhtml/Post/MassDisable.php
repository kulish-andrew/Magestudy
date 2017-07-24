<?php

namespace Magestudy\Crud\Controller\Adminhtml\Post;


use Magestudy\Crud\Controller\Adminhtml\AbstractMassDisable;
use Magestudy\Crud\Model\Post;
use Magestudy\Crud\Api\PostRepositoryInterface;
use Magestudy\Crud\Helper\AclResources;
use Magestudy\Crud\Model\ResourceModel\Post\Collection as PostCollection;

class MassDisable extends AbstractMassDisable
{
    /**
     * @return string
     */
    protected function _getAclResource()
    {
        return AclResources::POST_SAVE;
    }

    /**
     * @return string
     */
    protected function _getEntityTitle()
    {
        return Post::ENTITY_TITLE;
    }

    /**
     * @return string
     */
    protected function _getCollectionClass()
    {
        return PostCollection::class;
    }

    /**
     * @return string
     */
    protected function _getRepositoryClass()
    {
        return PostRepositoryInterface::class;
    }
}
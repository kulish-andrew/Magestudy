<?php

namespace Magestudy\Crud\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magestudy\Crud\Model\Category;
use Magestudy\Crud\Model\ResourceModel\Category as CategoryResource;
use Magestudy\Crud\Model\Post;
use Magestudy\Crud\Model\ResourceModel\Post as PostResource;
use Magestudy\Crud\Model\Tag;
use Magestudy\Crud\Model\ResourceModel\Tag as TagResource;
use Magestudy\Crud\Model\PostTag;
use Magestudy\Crud\Model\ResourceModel\PostTag as PostTagResource;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @return void
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists(CategoryResource::MAIN_TABLE)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(CategoryResource::MAIN_TABLE)
            )
                ->addColumn(
                    Category::ID, Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                    ], 'ID'
                )
                ->addColumn(
                    Category::IS_ACTIVE, Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 1],
                    'Is Active'
                )
                ->addColumn(
                    Category::TITLE, Table::TYPE_TEXT, 255, ['nullable' => false],
                    'Title'
                )
                ->addColumn(
                    Category::DESCRIPTION, Table::TYPE_TEXT, 1000, ['nullable' => false],
                    'Description'
                )
                ->addColumn(
                    Category::CREATION_TIME,
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Creation Time'
                )
                ->addColumn(
                    Category::UPDATE_TIME,
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Modification Time'
                )
                ->addIndex(
                    $installer->getIdxName(
                        CategoryResource::MAIN_TABLE,
                        [Category::TITLE],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [Category::TITLE],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->setComment('Category');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(CategoryResource::MAIN_TABLE,
                $installer->getIdxName(
                    CategoryResource::MAIN_TABLE,
                    [Category::TITLE],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ), [Category::TITLE], AdapterInterface::INDEX_TYPE_FULLTEXT);
        }

        if (!$installer->tableExists(PostResource::MAIN_TABLE)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(PostResource::MAIN_TABLE)
            )
                ->addColumn(
                    Post::ID, Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                    ], 'ID'
                )
                ->addColumn(
                    Post::CATEGORY_ID, Table::TYPE_INTEGER, null, ['nullable' => false],
                    'Category Id'
                )
                ->addColumn(
                    Post::IS_ACTIVE, Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 1],
                    'Is Active'
                )
                ->addColumn(
                    Post::TITLE, Table::TYPE_TEXT, 255, ['nullable' => false],
                    'Title'
                )
                ->addColumn(
                    Post::CONTENT, Table::TYPE_TEXT, '1M', ['nullable' => false],
                    'Content'
                )
                ->addColumn(
                    Post::VIEWS, Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => 0],
                    'Views'
                )
                ->addColumn(
                    Post::IMAGE, Table::TYPE_TEXT, 500, ['nullable' => true],
                    'Image'
                )
                ->addColumn(
                    Post::STORE_IDS, Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => "0"],
                    'Store Ids'
                )
                ->addColumn(
                    Post::PUBLICATION_DATE,
                    Table::TYPE_DATETIME,
                    null,
                    ['nullable' => true],
                    'Publication Time'
                )
                ->addColumn(
                    Post::UPDATE_TIME,
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                    'Modification Time'
                )
                ->addIndex(
                    $installer->getIdxName(
                        PostResource::MAIN_TABLE,
                        [Post::TITLE],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [Post::TITLE],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addForeignKey(
                    $installer->getFkName(
                        CategoryResource::MAIN_TABLE, Category::ID, PostResource::MAIN_TABLE,
                        Post::CATEGORY_ID
                    ),
                    Post::CATEGORY_ID,
                    $installer->getTable(CategoryResource::MAIN_TABLE),
                    Post::CATEGORY_ID,
                    Table::ACTION_CASCADE
                )
                ->setComment('Post');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(PostResource::MAIN_TABLE,
                $installer->getIdxName(
                    PostResource::MAIN_TABLE,
                    [Post::TITLE, Post::IMAGE],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ), [Category::TITLE, Post::IMAGE], AdapterInterface::INDEX_TYPE_FULLTEXT);
        }

        if (!$installer->tableExists(TagResource::MAIN_TABLE)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(TagResource::MAIN_TABLE)
            )
                ->addColumn(
                    Tag::ID, Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                    ], 'ID'
                )
                ->addColumn(
                    Tag::TITLE, Table::TYPE_TEXT, 255, ['nullable' => false],
                    'Title'
                )
                ->addIndex(
                    $installer->getIdxName(
                        TagResource::MAIN_TABLE,
                        [Tag::TITLE],
                        AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    [Tag::TITLE],
                    ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->setComment('Tag');
            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists(PostTagResource::MAIN_TABLE)) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable(PostTagResource::MAIN_TABLE)
            )
                ->addColumn(
                    PostTag::ID, Table::TYPE_INTEGER, null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                    ], 'ID'
                )
                ->addColumn(
                    PostTag::POST_ID, Table::TYPE_INTEGER, null, ['nullable' => false],
                    'Post id'
                )
                ->addColumn(
                    PostTag::TAG_ID, Table::TYPE_INTEGER, null, ['nullable' => false],
                    'Tag id'
                )
                ->addForeignKey(
                    $installer->getFkName(
                        PostResource::MAIN_TABLE, Post::ID, PostTagResource::MAIN_TABLE,
                        PostTag::POST_ID
                    ),
                    PostTag::POST_ID,
                    $installer->getTable(PostResource::MAIN_TABLE),
                    Post::ID,
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        TagResource::MAIN_TABLE, Tag::ID, PostTagResource::MAIN_TABLE,
                        PostTag::TAG_ID
                    ),
                    PostTag::TAG_ID,
                    $installer->getTable(TagResource::MAIN_TABLE),
                    Tag::ID,
                    Table::ACTION_CASCADE
                )
                ->setComment('Post Tag');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
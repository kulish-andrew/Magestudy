<?php

namespace Magestudy\Crud\Controller\Adminhtml;

use Magestudy\Crud\Helper\Data;

abstract class AbstractDelete extends AbstractAction
{
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(Data::FRONTEND_ID);
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
               $this->_deleteById($id);
                $this->messageManager->addSuccessMessage(__('The '.strtolower($this->_getEntityTitle()).' has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
                return $resultRedirect->setPath('*/*/edit', [Data::FRONTEND_ID => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a record to delete.'));
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param int $id
     */
    abstract protected function _deleteById($id);
}
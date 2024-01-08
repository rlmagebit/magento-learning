<?php

declare(strict_types=1);

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class PageList extends Template implements BlockInterface
{
    protected $_template = "widget/page_list.phtml";

    public function __construct(Template\Context $context, private readonly PageRepositoryInterface $pageRepository, private readonly SearchCriteriaBuilder $searchCriteriaBuilder, array $data = [])
    {
        parent::__construct($context, $data);
    }

    /**
     * @throws LocalizedException
     */
    public function getPages(): array
    {
        $displayMode = $this->getData('display_mode');
        $selectedPages = $this->getData('selected_pages');

        if ($displayMode == 'specific_pages' && !empty($selectedPages) && is_array($selectedPages)) {
            $searchCriteria = $this->searchCriteriaBuilder
                ->addFilter(PageInterface::TITLE, $selectedPages, 'in')
                ->create();

            return $this->pageRepository->getList($searchCriteria)->getItems();
        }

        return $this->pageRepository->getList($this->searchCriteriaBuilder->create())->getItems();
    }
}

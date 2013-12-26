<?php
/**
 * AnimeDb package
 *
 * @package   AnimeDb
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\ItemFolderFillerBundle\Service;

use AnimeDb\Bundle\CatalogBundle\Plugin\Item\Item as ItemPlugin;
use Knp\Menu\ItemInterface;
use AnimeDb\Bundle\CatalogBundle\Entity\Item as ItemEntity;

/**
 * Plugin item
 * 
 * @package AnimeDb\Bundle\ItemFolderFillerBundle\Service
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
class FillerFolder extends ItemPlugin
{
    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'item-folder-filler-bundle';
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return 'Item folder filler';
    }

    /**
     * Build menu for plugin
     *
     * @param \Knp\Menu\ItemInterface $node
     * @param \AnimeDb\Bundle\CatalogBundle\Entity\Item $item
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function buildMenu(ItemInterface $node, ItemEntity $item)
    {
        $node->addChild('Fill folder', [
            'route' => 'item_folder_filler_fill',
            'routeParameters' => [
                'id' => $item->getId(),
                'name' => $item->getName()
            ]
        ])
            ->setLinkAttribute('class', 'icon-label icon-fill');
    }
}
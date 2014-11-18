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
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Plugin item
 *
 * @package AnimeDb\Bundle\ItemFolderFillerBundle\Service
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
class FillerFolder extends ItemPlugin
{
    /**
     * Cover file name
     *
     * @var string
     */
    const COVER_FILE_NAME = 'cover';

    /**
     * Info file name
     *
     * @var string
     */
    const INFO_FILE_NAME = 'info';

    /**
     * Templating
     *
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templating;

    /**
     * Filesystem
     *
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * Root dir
     *
     * @var string
     */
    protected $root;

    /**
     * Construct
     *
     * @param \Symfony\Component\Templating\EngineInterface $templating
     * @param \Symfony\Component\Filesystem\Filesystem $fs
     * @param string $root
     */
    public function __construct(EngineInterface $templating, Filesystem $fs, $root)
    {
        $this->templating = $templating;
        $this->fs = $fs;
        $this->root = $root;
    }

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
        if ($item->getPath() && $this->fs->exists($item->getPath())) {
            $node->addChild('Fill folder', [
                'route' => 'item_folder_filler_fill',
                'routeParameters' => [
                    'id' => $item->getId(),
                    'name' => $item->getUrlName()
                ]
            ])
                ->setLinkAttribute('class', 'icon-label icon-fill');
        }
    }

    /**
     * Fill item folder
     *
     * @param \AnimeDb\Bundle\CatalogBundle\Entity\Item $item
     */
    public function fillFolder(ItemEntity $item)
    {
        if ($item->getPath() && $this->fs->exists($item->getPath())) {
            // write information about the item
            $this->fs->dumpFile(
                $item->getPath().'/'.self::INFO_FILE_NAME.'.html',
                $this->templating->render('AnimeDbItemFolderFillerBundle:Filler:info.html.twig', [
                    'item' => $item,
                    'cover' => $this->getCover($item)
                ])
            );
        }
    }

    /**
     * Get cover filename
     *
     * @param \AnimeDb\Bundle\CatalogBundle\Entity\Item $item
     *
     * @return string
     */
    protected function getCover(ItemEntity $item)
    {
        $from = $this->root.$item->getDownloadPath().'/'.$item->getCover();
        if (!$this->fs->exists($from)) {
            return '';
        }

        // copy cover
        $target = $item->getPath().'/';
        $filename = self::COVER_FILE_NAME.'.'.pathinfo($item->getCover(), PATHINFO_EXTENSION);
        if (is_file($item->getPath())) {
            $target = dirname($item->getPath()).'/';
            $filename = pathinfo($item->getPath(), PATHINFO_FILENAME).'-'.$filename;
        }
        $this->fs->copy($from, $target.$filename);
        return $filename;
    }
}

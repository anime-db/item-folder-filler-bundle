<?php
/**
 * AnimeDb package
 *
 * @package   AnimeDb
 * @author    Peter Gribanov <info@peter-gribanov.ru>
 * @copyright Copyright (c) 2011, Peter Gribanov
 * @license   http://opensource.org/licenses/GPL-3.0 GPL v3
 */

namespace AnimeDb\Bundle\ItemFolderFillerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AnimeDb\Bundle\CatalogBundle\Entity\Item;

/**
 * Filler
 *
 * @package AnimeDb\Bundle\ItemFolderFillerBundle\Controller
 * @author  Peter Gribanov <info@peter-gribanov.ru>
 */
class FillerController extends Controller
{
    /**
     * Fill item folder
     *
     * @param \AnimeDb\Bundle\CatalogBundle\Entity\Item $item
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fillAction(Item $item)
    {
        // do fill
        $this->get('anime_db.item_folder_filler.filler_folder')->fillFolder($item);

        return $this->render('AnimeDbItemFolderFillerBundle:Filler:fill.html.twig', [
            'item' => $item
        ]);
    }
}
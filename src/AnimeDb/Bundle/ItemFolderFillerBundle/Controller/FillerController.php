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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function fillAction()
    {
        return $this->render('AnimeDbItemFolderFillerBundle:Filler:filler.html.twig');
    }
}
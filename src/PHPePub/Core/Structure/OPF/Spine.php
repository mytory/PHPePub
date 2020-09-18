<?php
namespace PHPePub\Core\Structure\OPF;

/**
 * ePub OPF Spine structure
 *
 * @author    A. Grandt <php@grandt.com>
 * @copyright 2014- A. Grandt
 * @license   GNU LGPL 2.1
 */
class Spine {
    private $itemrefs = array();
    private $toc = null;
    private $pageProgressionDirection = null;

    /**
     * Class constructor.
     *
     * @param string $toc
     */
    function __construct($toc = "ncx", $pageProgressionDirection = EPub::DIRECTION_LEFT_TO_RIGHT) {
        $this->setToc($toc);
        $this->setPageProgressionDirection($pageProgressionDirection);
    }

    /**
     *
     * Enter description here ...
     *
     * @param string $toc
     */
    function setToc($toc) {
        $this->toc = is_string($toc) ? trim($toc) : null;
    }

    /**
     * setPageProgressionDirection function
     *
     * @param string $pageProgressionDirection
     */
    function setPageProgressionDirection($pageProgressionDirection) {
        $this->pageProgressionDirection = is_string($pageProgressionDirection) ? trim($pageProgressionDirection) : EPub::DIRECTION_LEFT_TO_RIGHT;
    }

    /**
     * Class destructor
     *
     * @return void
     */
    function __destruct() {
        unset($this->itemrefs, $this->toc, $this->pageProgressionDirection);
    }

    /**
     *
     * Enter description here ...
     *
     * @param Itemref $itemref
     */
    function addItemref($itemref) {
        if ($itemref != null
            && is_object($itemref)
            && $itemref instanceof Itemref
            && !isset($this->itemrefs[$itemref->getIdref()])
        ) {
            $this->itemrefs[$itemref->getIdref()] = $itemref;
        }
    }

    /**
     *
     * Enter description here ...
     *
     * @return string
     */
    function finalize() {
        $spine = "\n\t<spine toc=\"" . $this->toc . "\" page-progression-direction=\"" . $this->pageProgressionDirection . "\">\n";
        foreach ($this->itemrefs as $itemref) {
            /** @var $itemref ItemRef */
            $spine .= $itemref->finalize();
        }

        return $spine . "\t</spine>\n";
    }
}

<?php
/**
 * CLinkPager class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CLinkPager displays a list of hyperlinks that lead to different pages of target.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CLinkPager.php 3515 2011-12-28 12:29:24Z mdomba $
 * @package system.web.widgets.pagers
 * @since 1.0
 */
 
/**
 * Extended for the Infinite Scroll
 * @author Bryan Jayson Tan <admin@bryantan.info>.
 * @link http://bryantan.info
 * @date 12/15/12
 * @time 7:40 PM
 */
class InfiniteScrollLinkPager extends CLinkPager
{
	public $htmlOptions=array();


	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
        $this->getPages()->validateCurrentPage = false;
		parent::init();
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;

		echo $this->header;
		echo CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()

		if ($this->getPages()->getPageCount() > 0 && ($this->getPages()->getCurrentPage() >= $this->getPages()->getPageCount()) ){ // last page throw error, needs in masonry
            Yii::app()->end();
        }

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
	}

    /**
     * @return array the begin and end pages that need to be displayed.
     */
    protected function getPageRange()
    {
        $currentPage=$this->getCurrentPage();
        $pageCount=$this->getPageCount();

        $beginPage=max(0, $currentPage-(int)($this->maxButtonCount/2));
        if(($endPage=$beginPage+$this->maxButtonCount-1)>=$pageCount)
        {
            $endPage=$pageCount-1;
            $beginPage=max(0,$endPage-$this->maxButtonCount+1);
        }
        return array($beginPage,$endPage);
    }
}

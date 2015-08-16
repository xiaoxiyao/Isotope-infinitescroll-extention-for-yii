<?php
/**
 * @author Bryan Jayson Tan <admin@bryantan.info>.
 * @link http://bryantan.info
 * @date 12/15/12
 * @time 7:40 PM
 */
Yii::import('zii.widgets.CListView');
Yii::import('application.extensions.isotope.InfiniteScrollLinkPager');

class Isotope extends CListView
{
    /**
     * ID for the container, if set to null. we generate the ID
     * @var null
     */
    public $itemContainerId=null;

    /**
     * selector class of the item
     * @var string
     */
    public $itemSelectorClass='item';

    /**
     * options for the isotope jquery
     * @var array
     */
    public $options=array();

    /**
     * switch  infinite scroll
     * @var bool
     */
    public $infiniteScroll=true;

    /**
     * javascript options for infinite scroll
     * @var array
     */
    public $infiniteOptions=array();

    /**
     * callback script for infinite scroller
     * available only if infiniteScroll = true
     * @var null
     */
    public $infiniteCallback=null;

    //public $template="{pager}\n{items}";

    /**
     * @var null
     */
    private $_assetsUrl=null;

    private $_pagerId=null;

    public $pager=array('class'=>'InfiniteScrollLinkPager');

    public function init(){
        parent::init();
        if (!$this->itemContainerId){
            $this->itemContainerId=$this->getId();
        }
        if (!$this->itemSelectorClass){
            throw new CException('Item Selector cannot be blank');
        }
        //echo $this->itemContainerId;
    }

    public function run(){
        parent::run();

        $this->infiniteScrollScript();
    }

    public function registerClientScript()
    {
        $this->_assetsUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/assets');

        $cs = Yii::app()->clientScript;
        //$cs->registerScriptFile("{$this->_assetsUrl}/js/jquery.isotope.min.js",CClientScript::POS_END);
        $cs->registerScriptFile("{$this->_assetsUrl}/js/isotope.pkgd.min.js",CClientScript::POS_END);
        $cs->registerScriptFile("{$this->_assetsUrl}/js/imagesloaded.pkgd.min.js",CClientScript::POS_END);
        $this->options['itemSelector']='.'.$this->itemSelectorClass;
        $cs->registerScript('isotope',"var isoContainer = $('#{$this->itemContainerId} .{$this->itemsCssClass}');isoContainer.isotope(".CJavaScript::encode($this->options).");isoContainer.imagesLoaded(function(){isoContainer.isotope('layout');});");
    }

    protected function infiniteScrollScript(){
        if ($this->infiniteScroll===false){
            return;
        }

        $cs = Yii::app()->clientScript;
        $infiniteScrollScript = 'jquery.infinitescroll.js';
        $cs->registerScriptFile("{$this->_assetsUrl}/js/{$infiniteScrollScript}",CClientScript::POS_END);
        $cs->registerCssFile("{$this->_assetsUrl}/css/isotope.css");

        $options=$this->assignInfiniteOptions();
        $callback=$this->assignInfiniteCallback();

        $cs->registerScript('isotope-scroll',"isoContainer.infinitescroll({$options},{$callback});");//
        $cs->registerCss('isotope-pager',"#{$this->itemContainerId} .{$this->pagerCssClass} { display:none; }");
    }

    protected function assignInfiniteOptions(){
        $debug = false;//YII_DEBUG ? true : false;

        $this->infiniteOptions['navSelector']="#{$this->itemContainerId} .{$this->pagerCssClass}";
        $this->infiniteOptions['nextSelector']="#{$this->itemContainerId} .{$this->pagerCssClass} .next a";

        $this->infiniteOptions['itemSelector']='.'.$this->itemSelectorClass;
        $this->infiniteOptions['debug']=$debug;
        return CJavaScript::encode($this->infiniteOptions);
    }

    protected function assignInfiniteCallback(){
        // trigger Masonry as a callback
        $defaultCallback="function( newElements ) { var newElems = jQuery( newElements ); isoContainer.isotope( 'appended', newElems);isoContainer.imagesLoaded(function(){isoContainer.isotope('layout');}); {$this->infiniteCallback}}";
        return $defaultCallback;
    }
}

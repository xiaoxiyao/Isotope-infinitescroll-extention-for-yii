# Isotope-infinitescroll-extention-for-yii
基于[Isotope](https://github.com/metafizzy/isotope)和[infinitescroll](https://github.com/infinite-scroll/infinite-scroll)实现的无限滚动瀑布流插件，适用于yii1.1

##使用方法
```php
$this->widget('ext.isotope.Isotope', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_pic',
            'itemSelectorClass' => 'pic_container',
            'options' => array(),
            //'infiniteScroll'=>false,
            'template' => '{items}{pager}',
            'infiniteOptions'=>array(
                'loading'=>array(
                    'finishedMsg'=>'<em>已加载全部数据</em>',
                    'msgText'=>'<em>加载中</em>',
                    'speed'=>'normal',
                ),
                //'binder'=>'js:$("body")',
                'bufferPx'=>0,
                'pixelsFromNavToBottom'=>10,
            ),
        ));
```

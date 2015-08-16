# Isotope-infinitescroll-extention-for-yii
基于[Isotope](https://github.com/metafizzy/isotope)和[infinitescroll](https://github.com/infinite-scroll/infinite-scroll)实现的无限滚动瀑布流插件，适用于yii1.1

##使用方法
####Controller
```php
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Picture', array(
            'criteria' => array(
                //'condition' => $condition,
                'order' => 'pic_type DESC,pic_index',
                //'with' => array('author'),
            ),
            'pagination' => array(
                'pageSize' => 8,
            ),
        ));
        $this->render('index',array('dataProvider'=>$dataProvider));
    }
```
####View
```php
    $this->widget('ext.isotope.Isotope', array(   //继承自CListView
            'dataProvider' => $dataProvider,
            'itemView' => '_pic',
            'itemSelectorClass' => 'pic_container', //isotope插件的itemSelector配置项，类选择器
            'options' => array(),
            'template' => '{items}{pager}',
            'infiniteOptions'=>array(            //请参考infiniteScroll的参数设置
                'loading'=>array(
                    'finishedMsg'=>'<em>已加载全部数据</em>',
                    'msgText'=>'<em>加载中</em>',
                    'speed'=>'normal',
                ),
                'bufferPx'=>0,
                'pixelsFromNavToBottom'=>10,
            ),
        ));
```

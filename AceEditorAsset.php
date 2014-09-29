<?php
/**
 * @copyright Copyright &copy; Aleksey Loban, lav451@gmail.com, 2014
 * @package lav45/yii2-aceeditor
 * @version 1.0.0
 */

namespace lav45\aceEditor;

use yii\web\AssetBundle;

class AceEditorAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/lav45/ace-builds/src-min-noconflict';

    /**
     * @inheritdoc
     */
    public $js = ['ace.js'];
}
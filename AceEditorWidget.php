<?php
/**
 * @copyright Copyright &copy; Aleksey Loban, lav451@gmail.com, 2014
 * @package lav45/yii2-aceeditor
 * @version 1.0.0
 *
 * echo $form->field($model, 'text')->widget(AceEditorWidget::className());
 *
 * echo $form->field($model, 'content')->widget(AceEditorWidget::className(), [
 *     'containerOptions' => [
 *         'id' => 'editor',
 *         'style' => 'width: 100%; min-height: 400px;',
 *     ],
 *     'editorSettings' => "
 *         editor.setTheme('ace/theme/idle_fingers');
 *         editor.getSession().setMode('ace/mode/html');
 *     ",
 * ]);
 *
 * OR
 *
 * // Ace editor without model
 * echo AceEditorWidget::widget([
 *     'name' => 'description',
 *     'value' => 'same text',
 * ]);
 */

namespace lav45\aceEditor;

use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\InputWidget;

class AceEditorWidget extends InputWidget
{
    /**
     * This configuration of the container in which you will install the editor
     * @var array Div options
     */
    public $containerOptions = [
        'style' => 'min-height: 400px;'
    ];

    /**
     * @var string JS Settings for AceEditor
     * @link http://ace.c9.io/#nav=howto
     */
    public $editorSettings = "
        editor.setTheme('ace/theme/idle_fingers');
        editor.getSession().setMode('ace/mode/html');
    ";

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-editor';
        }

        $this->registerAssets();
        $this->registerJS();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $div = Html::tag('div', '', $this->containerOptions);

        Html::addCssStyle($this->options, 'display: none;');

        if ($this->hasModel()) {
            return $div . Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            return $div . Html::textarea($this->name, $this->value, $this->options);
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        AceEditorAsset::register($this->getView());
    }

    /**
     * Registers a specific plugin settings
     */
    public function registerJS()
    {
        $text = Inflector::slug($this->options['id'], '_');
        $editor = Inflector::slug($this->containerOptions['id'], '_');

        $this->getView()->registerJs("
            var $text = $('#{$this->options['id']}');
            var $editor = ace.edit('{$this->containerOptions['id']}');

            $editor.getSession().setValue($text.val());
            $editor.getSession().on('change', function(){
                $text.val($editor.getSession().getValue());
            });

            (function(editor){
                {$this->editorSettings}
            }($editor));
        ");
    }
}
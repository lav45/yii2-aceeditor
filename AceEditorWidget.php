<?php
/**
 * @copyright Copyright &copy; Aleksey Loban, lav451@gmail.com, 2014
 * @package lav45/yii2-aceeditor
 * @version 1.1.0
 *
 * echo $form->field($model, 'content')->widget(AceEditorWidget::className(), [
 *     'theme' => 'xcode',
 *     'mode' => 'html',
 *     'showPrintMargin' => false,
 *     'fontSize' => 14,
 *     'height' => 400,
 *     'options' => [
 *         'style' => 'border: 1px solid #ccc; border-radius: 4px;'
 *     ]
 * ]);
 *
 * OR
 *
 * // Ace editor without model
 * echo AceEditorWidget::widget([
 *     'name' => 'description',
 *     'value' => 'text value',
 *     'theme' => 'idle_fingers',
 *     'mode' => 'html',
 * ]);
 */

namespace lav45\aceEditor;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class AceEditorWidget extends InputWidget
{
    /**
     * @var string JS Settings for AceEditor
     */
    private $_editorSettings;

    /**
     * The height of the editor
     * @param integer
     */
    public $height = 300;

    /**
     * @var boolean
     */
    private $_read_only = false;

    /**
     * Using this method, you can add arbitrary javascript code
     * @param $str string
     */
    public function setEditorSettings($str)
    {
        $this->addSettings($str);
    }

    /**
     * Themes are loaded on demand; all you have to do is pass the string name:
     *
     * @param $value string
     * - ambiance
     * - chaos
     * - chrome
     * - clouds
     * - clouds_midnight
     * - cobalt
     * - crimson_editor
     * - dawn
     * - dreamweaver
     * - eclipse
     * - github
     * - idle_fingers
     * - katzenmilch
     * - kr_theme
     * - kuroir
     * - merbivore
     * - merbivore_soft
     * - mono_industrial
     * - monokai
     * - pastel_on_dark
     * - solarized_dark
     * - solarized_light
     * - terminal
     * - textmate
     * - tomorrow
     * - tomorrow_night_blue
     * - tomorrow_night_bright
     * - tomorrow_night_eighties
     * - tomorrow_night
     * - twilight
     * - vibrant_ink
     * - xcode
     */
    public function setTheme($value)
    {
        $this->addSettings("editor.setTheme('ace/theme/$value');");
    }

    /**
     * By default, the editor supports plain text mode. All other language modes are available
     * as separate modules, loaded on demand like this:
     *
     * @param $value string
     * - abap
     * - actionscript
     * - ada
     * - apache_conf
     * - applescript
     * - asciidoc
     * - assembly_x86
     * - autohotkey
     * - batchfile
     * - c9search
     * - c_cpp
     * - cirru
     * - clojure
     * - cobol
     * - coffee
     * - coldfusion
     * - csharp
     * - css
     * - curly
     * - dart
     * - diff
     * - django
     * - d
     * - dockerfile
     * - dot
     * - eiffel
     * - ejs
     * - erlang
     * - forth
     * - ftl
     * - gcode
     * - gherkin
     * - gitignore
     * - glsl
     * - golang
     * - groovy
     * - haml
     * - handlebars
     * - haskell
     * - haxe
     * - html
     * - html_ruby
     * - ini
     * - io
     * - jack
     * - jade
     * - java
     * - javascript
     * - jsoniq
     * - json
     * - jsp
     * - jsx
     * - julia
     * - latex
     * - less
     * - liquid
     * - lisp
     * - livescript
     * - logiql
     * - lsl
     * - lua
     * - luapage
     * - lucene
     * - makefile
     * - markdown
     * - matlab
     * - mel
     * - mushcode
     * - mysql
     * - nix
     * - objectivec
     * - ocaml
     * - pascal
     * - perl
     * - pgsql
     * - php
     * - plain_text
     * - powershell
     * - praat
     * - prolog
     * - properties
     * - protobuf
     * - python
     * - rdoc
     * - rhtml
     * - r
     * - ruby
     * - rust
     * - sass
     * - scad
     * - scala
     * - scheme
     * - scss
     * - sh
     * - sjs
     * - smarty
     * - snippets
     * - soy_template
     * - space
     * - sql
     * - stylus
     * - svg
     * - tcl
     * - tex
     * - textile
     * - text
     * - toml
     * - twig
     * - typescript
     * - vala
     * - vbscript
     * - velocity
     * - verilog
     * - vhdl
     * - xml
     * - xquery
     * - yaml
     */
    public function setMode($value)
    {
        $this->addSettings("editor.session.setMode('ace/mode/$value');");
    }

    /**
     * Font size text in editor
     * @param $value integer
     */
    public function setFontSize($value)
    {
        $this->addSettings("editor.setFontSize($value);");
    }

    /**
     * Code Folding
     *
     * @param $value string
     *  - manual
     *  - markbegin
     *  - markbeginend
     */
    public function setFoldStyle($value)
    {
        $this->addSettings("
            editor.session.setFoldStyle('$value');
            editor.setShowFoldWidgets($value !== 'manual');
        ");
    }

    /**
     * Key Binding
     *
     * @param $value string
     * - ace
     * - vim
     * - emacs
     * - custom
     */
    public function setKeyBinding($value)
    {
        $this->addSettings("editor.setKeyboardHandler('$value');");
    }

    /**
     * Soft Wrap
     *
     * @param $value integer|string
     * - off
     * - 40
     * - 80
     * - free
     */
    public function setSoftWrap($value)
    {
        $this->addSettings("editor.setOption('wrap', '$value');");
    }

    /**
     * Full Line Selection
     * @param $value boolean
     */
    public function setSelectionStyle($value)
    {
        $value = $value ? 'line' : 'text';
        $this->addSettings("editor.setOption('selectionStyle', $value);");
    }

    /**
     * Highlight Active Line
     * @param $value boolean
     */
    public function setHighlightActiveLine($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setHighlightActiveLine($value);");
    }

    /**
     * Show Invisibles
     * @param $value boolean
     */
    public function setShowInvisibles($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setShowInvisibles($value);");
    }

    /**
     * Show Indent Guides
     * @param $value boolean
     */
    public function setDisplayIndentGuides($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setDisplayIndentGuides($value);");
    }

    /**
     * Show height scroll bar always visible
     * @param $value boolean
     */
    public function setHScrollBar($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('hScrollBarAlwaysVisible', $value);");
    }

    /**
     * Show vertical scroll bar always visible
     * @param $value boolean
     */
    public function setVScrollBar($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('vScrollBarAlwaysVisible', $value);");
    }

    /**
     * Show Animate scrolling
     * @param $value boolean
     */
    public function setAnimatedScroll($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setAnimatedScroll($value);");
    }

    /**
     * Show Gutter
     * @param $value boolean
     */
    public function setShowGutter($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.renderer.setShowGutter($value);");
    }

    /**
     * Show Print Margin
     * @param $value boolean
     */
    public function setShowPrintMargin($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.renderer.setShowPrintMargin($value);");
    }

    /**
     * Use Soft Tab
     * @param $value boolean
     */
    public function setUseSoftTabs($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.session.setUseSoftTabs($value);");
    }

    /**
     * Highlight selected word
     * @param $value boolean
     */
    public function setHighlightSelectedWord($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setHighlightSelectedWord($value);");
    }

    /**
     * Enable Behaviours
     * @param $value boolean
     */
    public function setBehavioursEnabled($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setBehavioursEnabled($value);");
    }

    /**
     * Fade Fold Widgets
     * @param $value boolean
     */
    public function setFadeFoldWidgets($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setFadeFoldWidgets($value);");
    }

    /**
     * Enable Elastic Tabstops
     * @param $value boolean
     */
    public function setUseElasticTabstops($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('useElasticTabstops', $value);");
    }

    /**
     * Incremental Search
     * @param $value boolean
     */
    public function setUseIncrementalSearch($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('useIncrementalSearch', $value);");
    }

    /**
     * Read-only
     * @param $value boolean
     */
    public function setReadOnly($value)
    {
        $this->_read_only = $value;
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('readOnly', $value);");
    }

    /**
     * Scroll Past End
     * @param $value boolean
     */
    public function setScrollPastEnd($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('scrollPastEnd', $value);");
    }

    /**
     * Auto Scroll Editor Into View
     * @param $value boolean
     */
    public function setAutoScrollEditorIntoView($value)
    {
        $value = var_export($value, true);
        $this->addSettings("editor.setOption('autoScrollEditorIntoView', $value);");
    }

    /**
     * Max Lines View
     * @param $value integer
     */
    public function setMaxLines($value)
    {
        $this->addSettings("editor.setOption('maxLines', $value);");
    }

    /**
     * Min Lines View
     * @param $value integer
     */
    public function setMinLines($value)
    {
        $this->addSettings("editor.setOption('minLines', $value);");
    }

    /**
     * Append to general settings
     * @param $str string
     */
    protected function addSettings($str)
    {
        $this->_editorSettings .= "$str\n";
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
        $this->registerJS();

        if ($this->height !== null) {
            Html::addCssStyle($this->options, "height: {$this->height}px;");
        }

        $content = Html::tag('div', '', $this->options);

        $containerOptions = [
            'style' => 'display: none;',
            'id' => $this->options['id'] . '-container'
        ];

        if ($this->_read_only !== false) {
            $containerOptions['readonly'] = '';
        }

        $content .= $this->hasModel() ?
            Html::activeTextarea($this->model, $this->attribute, $containerOptions) :
            Html::textarea($this->name, $this->value, $containerOptions);

        return $content;
    }

    /**
     * Registers assets bundle
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
        $this->getView()->registerJs("
            (function($){
                var text = $('#{$this->options['id']}-container');
                var editor = ace.edit('{$this->options['id']}');

                editor.session.setValue(text.val());
                editor.session.on('change', function(){
                    text.val(editor.getSession().getValue());
                });

                {$this->_editorSettings}
            }(jQuery));
        ");
    }
}
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
     * The height of the editor
     * @param integer
     */
    public $height = 300;
    /**
     * @var string JS Settings for AceEditor
     */
    private $editorSettings;
    /**
     * @var array
     */
    private $containerOptions = [];

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
     * @param string $value
     * - ambiance
     * - chaos
     * - chrome
     * - clouds
     * - clouds_midnight
     * - cobalt
     * - crimson_editor
     * - dawn
     * - dracula
     * - dreamweaver
     * - eclipse
     * - github
     * - gob
     * - gruvbox
     * - idle_fingers
     * - iplastic
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
     * - sqlserver
     * - terminal
     * - textmate
     * - tomorrow
     * - tomorrow_night
     * - tomorrow_night_blue
     * - tomorrow_night_bright
     * - tomorrow_night_eighties
     * - twilight
     * - vibrant_ink
     * - xcode
     */
    public function setTheme($value)
    {
        $this->addSettings("editor.setTheme('./theme/{$value}');");
    }

    /**
     * By default, the editor supports plain text mode. All other language modes are available
     * as separate modules, loaded on demand like this:
     *
     * @param string $value
     * - abap
     * - abc
     * - actionscript
     * - ada
     * - apache_conf
     * - applescript
     * - asciidoc
     * - asl
     * - assembly_x86
     * - autohotkey
     * - batchfile
     * - bro
     * - c9search
     * - c_cpp
     * - cirru
     * - clojure
     * - cobol
     * - coffee
     * - coldfusion
     * - csharp
     * - csound_document
     * - csound_orchestra
     * - csound_score
     * - csp
     * - css
     * - curly
     * - d
     * - dart
     * - diff
     * - django
     * - dockerfile
     * - dot
     * - drools
     * - edifact
     * - eiffel
     * - ejs
     * - elixir
     * - elm
     * - erlang
     * - forth
     * - fortran
     * - fsharp
     * - ftl
     * - gcode
     * - gherkin
     * - gitignore
     * - glsl
     * - gobstones
     * - golang
     * - graphqlschema
     * - groovy
     * - haml
     * - handlebars
     * - haskell
     * - haskell_cabal
     * - haxe
     * - hjson
     * - html
     * - html_elixir
     * - html_ruby
     * - ini
     * - io
     * - jack
     * - jade
     * - java
     * - javascript
     * - json
     * - jsoniq
     * - jsp
     * - jssm
     * - jsx
     * - julia
     * - kotlin
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
     * - mask
     * - matlab
     * - maze
     * - mel
     * - mixal
     * - mushcode
     * - mysql
     * - nix
     * - nsis
     * - objectivec
     * - ocaml
     * - pascal
     * - perl
     * - pgsql
     * - php
     * - php_laravel_blade
     * - pig
     * - plain_text
     * - powershell
     * - praat
     * - prolog
     * - properties
     * - protobuf
     * - python
     * - r
     * - razor
     * - rdoc
     * - red
     * - redshift
     * - rhtml
     * - rst
     * - ruby
     * - rust
     * - sass
     * - scad
     * - scala
     * - scheme
     * - scss
     * - sh
     * - sjs
     * - slim
     * - smarty
     * - snippets
     * - soy_template
     * - space
     * - sparql
     * - sql
     * - sqlserver
     * - stylus
     * - svg
     * - swift
     * - tcl
     * - terraform
     * - tex
     * - text
     * - textile
     * - toml
     * - tsx
     * - turtle
     * - twig
     * - typescript
     * - vala
     * - vbscript
     * - velocity
     * - verilog
     * - vhdl
     * - wollok
     * - xml
     * - xquery
     * - yaml
     */
    public function setMode($value)
    {
        $this->addSettings("editor.session.setMode('ace/mode/{$value}');");
    }

    /**
     * Font size text in editor
     * @param int $value
     */
    public function setFontSize($value)
    {
        $this->addSettings("editor.setOption('fontSize', {$value});");
    }

    /**
     * Font family text in editor
     * @param int $value
     */
    public function setFontFamily($value)
    {
        $this->addSettings("editor.setOption('fontFamily', {$value});");
    }

    /**
     * Code Folding
     *
     * @param string $value
     *  - manual
     *  - markbegin
     *  - markbeginend
     */
    public function setFoldStyle($value)
    {
        $this->addSettings("editor.session.setFoldStyle('{$value}');");
    }

    /**
     * Show Fold Widgets
     * @param bool $value
     */
    public function setShowFoldWidgets($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('showFoldWidgets', {$value});");
    }

    /**
     * Key Binding
     *
     * @param string $value
     * - ace
     * - vim
     * - emacs
     * - custom
     */
    public function setKeyBinding($value)
    {
        $this->addSettings("editor.setKeyboardHandler('{$value}');");
    }

    /**
     * Wrap
     *
     * @param int|string $value
     * - off
     * - 40
     * - 80
     * - free
     */
    public function setWrap($value)
    {
        $this->addSettings("editor.setOption('wrap', '{$value}');");
    }

    /**
     * To toggle word wrapping
     * @param bool $value
     */
    public function setUseWrapMode($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.session.setUseWrapMode({$value});");
    }

    /**
     * Full Line Selection
     * @param bool $value
     */
    public function setSelectionStyle($value)
    {
        $value = $value ? 'line' : 'text';
        $this->addSettings("editor.setOption('selectionStyle', {$value});");
    }

    /**
     * Highlight Active Line
     * @param bool $value
     */
    public function setHighlightActiveLine($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('highlightActiveLine', {$value});");
    }

    /**
     * Highlight Gutter Line
     * @param bool $value
     */
    public function setHighlightGutterLine($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('highlightGutterLine', {$value});");
    }

    /**
     * Show Invisibles
     * @param bool $value
     */
    public function setShowInvisibles($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('showInvisibles', {$value});");
    }

    /**
     * Show Indent Guides
     * @param bool $value
     */
    public function setDisplayIndentGuides($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('displayIndentGuides', {$value});");
    }

    /**
     * Show height scroll bar always visible
     * @param bool $value
     */
    public function setHScrollBarAlwaysVisible($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('hScrollBarAlwaysVisible', {$value});");
    }

    /**
     * Show vertical scroll bar always visible
     * @param bool $value
     */
    public function setVScrollBarAlwaysVisible($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('vScrollBarAlwaysVisible', {$value});");
    }

    /**
     * Show Animate scrolling
     * @param bool $value
     */
    public function setAnimatedScroll($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('animatedScroll', {$value});");
    }

    /**
     * Show Gutter
     * @param bool $value
     */
    public function setShowGutter($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('showGutter', {$value});");
    }

    /**
     * Show Print Margin
     * @param bool $value
     */
    public function setShowPrintMargin($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('showPrintMargin', {$value});");
    }

    /**
     * Print Margin Column
     * @param int $value
     */
    public function setPrintMarginColumn($value)
    {
        $this->addSettings("editor.setOption('printMarginColumn', {$value});");
    }

    /**
     * Use Soft Tab
     * @param bool $value
     */
    public function setUseSoftTabs($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('useSoftTabs', {$value});");
    }

    /**
     * Tab Size
     * @param int $value
     */
    public function setTabSize($value)
    {
        $this->addSettings("editor.setOption('tabSize', {$value});");
    }

    /**
     * Atomic soft tabs
     * @param bool $value
     */
    public function setNavigateWithinSoftTabs($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('navigateWithinSoftTabs', {$value});");
    }

    /**
     * @param bool $value
     */
    public function setOverwrite($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('overwrite', {$value});");
    }

    /**
     * @param bool $value
     */
    public function setUseWorker($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('useWorker', {$value});");
    }

    /**
     * Highlight selected word
     * @param bool $value
     */
    public function setHighlightSelectedWord($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('highlightSelectedWord', {$value});");
    }

    /**
     * Enable Behaviours
     * @param bool $value
     */
    public function setBehavioursEnabled($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('behavioursEnabled', {$value});");
    }

    /**
     * Enable wrap behaviours
     * @param bool $value
     */
    public function setWrapBehavioursEnabled($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('wrapBehavioursEnabled', {$value});");
    }

    /**
     * Fade Fold Widgets
     * @param bool $value
     */
    public function setFadeFoldWidgets($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('fadeFoldWidgets', {$value});");
    }

    /**
     * Enable Elastic Tabstops
     * @param bool $value
     */
    public function setUseElasticTabstops($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('useElasticTabstops', {$value});");
    }

    /**
     * Incremental Search
     * @param bool $value
     */
    public function setUseIncrementalSearch($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('useIncrementalSearch', {$value});");
    }

    /**
     * Read-only
     * @param bool $value
     */
    public function setReadOnly($value)
    {
        if ($value) {
            $this->containerOptions['readonly'] = '';
        }
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('readOnly', {$value});");
    }

    /**
     * Scroll Past End
     * @param int $value
     */
    public function setScrollPastEnd($value)
    {
        $this->addSettings("editor.setOption('scrollPastEnd', {$value});");
    }

    /**
     * Auto Scroll Editor Into View
     * @param bool $value
     */
    public function setAutoScrollEditorIntoView($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('autoScrollEditorIntoView', {$value});");
    }

    /**
     * Fixed Width Gutter
     * @param bool $value
     */
    public function setFixedWidthGutter($value)
    {
        $value = $this->getBoolValue($value);
        $this->addSettings("editor.setOption('fixedWidthGutter', {$value});");
    }

    /**
     * Max Lines View
     * @param int $value
     */
    public function setMaxLines($value)
    {
        $this->addSettings("editor.setOption('maxLines', {$value});");
    }

    /**
     * Min Lines View
     * @param int $value
     */
    public function setMinLines($value)
    {
        $this->addSettings("editor.setOption('minLines', {$value});");
    }

    /**
     * Max Pixel Height
     * @param int $value
     */
    public function setMaxPixelHeight($value)
    {
        $this->addSettings("editor.setOption('maxPixelHeight', {$value});");
    }

    /**
     * Scroll speed
     * @param int $value
     */
    public function setScrollSpeed($value)
    {
        $this->addSettings("editor.setOption('scrollSpeed', {$value});");
    }

    /**
     * Drag delay
     * @param int $value
     */
    public function setDragDelay($value)
    {
        $this->addSettings("editor.setOption('dragDelay', {$value});");
    }

    /**
     * @param int|bool $value
     * @return string
     */
    protected function getBoolValue($value)
    {
        return var_export((bool)$value, true);
    }

    /**
     * Append to general settings
     * @param $str string
     */
    protected function addSettings($str)
    {
        $this->editorSettings .= "$str\n";
    }

    /**
     * @param int $value
     */
    public function setHeight($value)
    {
        Html::addCssStyle($this->options, "height: {$value}px;");
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerAssets();
        $this->registerJS();
        $this->setHeight($this->height);

        $this->containerOptions['style'] = 'display: none;';
        $this->containerOptions['id'] = $this->options['id'];

        $this->options['id'] .= '-container';
        $content = Html::tag('div', '', $this->options);

        $content .= $this->hasModel() ?
            Html::activeTextarea($this->model, $this->attribute, $this->containerOptions) :
            Html::textarea($this->name, $this->value, $this->containerOptions);

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
                var text = $('#{$this->options['id']}');
                var editor = ace.edit('{$this->options['id']}-container');

                editor.session.setValue(text.val());
                editor.session.on('change', function(){
                    text.val(editor.getSession().getValue());
                });

                {$this->editorSettings}
            }(jQuery));
        ");
    }
}
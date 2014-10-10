Yii 2 widget AceEditor
===========================

This extension allows you to install and use the code editor [Ace](http://ace.c9.io/)

[DEMO](http://ace.c9.io/build/kitchen-sink.html)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

> Note: You must set the `minimum-stability` to `dev` in the **composer.json** file in your application root folder before installation of this extension.

Either of your `composer.json` file

```json
    "minimum-stability": "dev",
    "require": {
        "lav45/yii2-aceeditor": "dev-master"
    }
```

## Usage

### How to call?
```php
	// add this in your view
	use lav45\aceEditor\AceEditorWidget;
```

```php
	echo $form->field($model, 'content')->widget(AceEditorWidget::className(), [
	    /**
	     * This configuration of the container in which you will install the editor
	     * return <div id="editor" style="width: 100%; min-height: 400px;"><div>
	     */
		'containerOptions' => [
		    'id' => 'editor',
            'style' => 'width: 100%; min-height: 400px;',
        ],

        /**
         * JS Settings for AceEditor
         * details can be found on http://ace.c9.io/#nav=howto
         */
        'editorSettings' => "
            editor.setTheme('ace/theme/idle_fingers');
            editor.getSession().setMode('ace/mode/html');
        ",
	]);

	// Ace editor without model
	echo AceEditorWidget::widget([
		'name' => 'description',
		'value' => 'same text',
	]);
```
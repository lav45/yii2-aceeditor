Yii 2 widget AceEditor
===========================

This extension allows you to install and use the code editor [Ace](http://ace.c9.io/)

[DEMO](http://ace.c9.io/build/kitchen-sink.html)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist lav45/yii2-aceeditor "1.1.*"
```

or add

```json
	"lav45/yii2-aceeditor": "1.1.*"
```

## Usage

### How to call?
```php
	use lav45\aceEditor\AceEditorWidget;

	echo $form->field($model, 'content')->widget(AceEditorWidget::className(), [
        'theme' => 'xcode',
        'mode' => 'html',
        'showPrintMargin' => false,
        'fontSize' => 14,
        'height' => 300,
        'options' => [
            'style' => 'border: 1px solid #ccc; border-radius: 4px;'
        ]
 	]);

	// Ace editor without model
	echo AceEditorWidget::widget([
		'name' => 'description',
		'value' => 'same text',
	]);
```

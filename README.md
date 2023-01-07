Yii2 Simple Invoice
===================
Yii2 Simple Invoice

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist harrytang/yii2-simpleinvoice "*"
```

or add

```
"harrytang/yii2-simpleinvoice": "*"
```

to the require section of your `composer.json` file.


then run

```
yii migrate --migrationPath=@vendor/harrytang/yii2-simpleinvoice/migrations/ --migrationTable={{%simpleinvoice_migration}}
```
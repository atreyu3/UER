Yii2 Material Design for Bootstrap Asset
=================
Material Design for Bootstrap Asset for Yii2 Web Application. Material design theme for Bootstrap 3 https://github.com/FezVrasta/bootstrap-material-design

Installation
------------

Add 

```
"repositories":
            [
                {
                    "type": "vcs",
                    "url": "https://github.com/mist-webit/yii2-bootstrap-material-design"
                }
            ],
```

to your composer.json file and add 

```
"mist-webit/yii2-bootstrap-material-design": "*"
```
to the require section of your composer.json file.

Usage
-----

Open your layout views/layouts/main.php and add

```
use mistwebit\materialbootstrap;

materialbootstrap\MaterialLoaderAsset::register($this);
```

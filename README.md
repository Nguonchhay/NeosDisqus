Nguonchhay.NeosDisqus
---------------------

This is the comment plugin for Neos base on [DISQUE](https://disqus.com/).
Compatible with Neos 2.x, 3.x

Installation
------------

* Install plugin
```bash
composer require "nguonchhay/neosdisqus:dev-master"
```

* Add `disqusEmbeddedScript` property to your root page (.yaml)

```bash
disqusEmbeddedScript:
  type: string
  ui:
    label: 'Disqus embedded script link'
    reloadIfChanged: TRUE
    inspector:
      group: 'document'
      editor: Neos.Neos/Inspector/Editors/TextAreaEditor
      editorOptions:
        placeholder: 'Enter Disqus embedded script link'
        rows: 10
```

* Create a `Partials` folder in side your `Resource/Private/Page` if you do not have one.

* Copy the `Disqus` template and Fusion to your running site by running command below
```bash
./flow activate:disqus
```

* Include the copied comment template into the page that you want to display
```html
<f:render partial="Comment" arguments="{_all}" />
```

* Clear cache
```bash
./flow flow:cache:flush -f
```

Then go to back end to add the Disqus embedded script at root page.

__Note__: the `Disqus` comments are rendered only on the LIVE environment in order to save the loading 
speed of back-end.

silverstripe-flexichoice
========================

SilverStripe field for providing arbitrary text input or selecting from YAML configurable presets.


Requirements
------------

[SilverStripe](http://www.silverstripe.org/) 3+


Screenshots
-----------

![flexichoice field](docs/screenshots/silverstripe-flexichoice.gif?raw=true)


Usage 
=====

* Add `FlexiChoice` field types to your `DataObject`(s) 

```php
class BlockContentHeading extends DataObject {
  private static $db = array(
    'Title'     => 'Varchar',
    'Content'   => 'Text',
    'Link'      => 'FlexiLink',
    'LinkText'  => 'FlexiChoice', // <--- here
  );
  
```

Trigger the environment builder (/dev/build) after extending objects --
You will now see the `FlexiChoiceField` appear in the CMS when editing your
object. 

* Define presets in [YAML Configuration](http://doc.silverstripe.org/framework/en/topics/configuration)

```yaml
FlexiChoiceField:
  choices:
    - LEARN MORE
    - READ MORE
    - MORE
    - GET STARTED
```

You may of course subclass `FlexiChoiceField` to provide multiple fields with
different choice selections.



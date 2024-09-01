# Userguide Bundle

Bundle for Symfony for creating user guides inside your application.  
The user guides are displayed inside the application inside the template.  

## Requirements

The bundle requires assets to be installed in the public directory.

## Installation

1. Install the bundle using composer
```bash
composer require norvutec/userguide
```
2. Add the bundle to the kernel (if not using symfony/flex)
```php
// config/bundles.php
return [
    // ...
    Norvutec\UserguideBundle\NorvutecUserguideBundle::class => ['all' => true],
];
```

3. Add the styles and scripts to your template
```twig
{% block stylesheets %}
    {{ parent() }}
    <link rel="stylesheet" href="{{ asset('bundles/norvutecuserguide/css/userguide.css') }}">
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    {{ userGuideJavascript() }}
{% endblock %}
``` 




# TODO INFOS FÜR MICH 


endswith: [id$=foo]
startswith[id^=foo]

override tooltip.html.twig
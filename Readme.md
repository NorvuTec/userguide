# UserGuide Bundle

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

4. Add user guide classes to your application
```php
class InvoiceFormUserGuide extends UserGuide {

    public function name(): string
    {
        return "invoiceform";
    }

    public function configure(UserGuideBuilder $builder): void {
        $builder
            ->route("app_accounting_invoice_new") # Main Route for the guide
            ->alternateRoute("app_accounting_invoice_edit") # Alternate Route for the guide
            ->add("[id$=form_invoiceNo]", "Insert Number of invoice here") # Add a step to the guide
            ->add("[id$=form_customer]", "Select customer here"); # Add a step to the guide
    }
}
```
> The ``add(Selector, Content, Options)``-Method have to be called in the correct order for the guide.
> The ``Selector`` is a javascript selector to select the element in the DOM. You can use all available syntaxes for ``querySelectorAll``. The guide will use the first element found for the steps link.

5. Include start button inside of your template (optional) (TODO)
```twig
{{ userGuideButton() }}
```

## Configuration / Overrides

### Path Security
The user guide bundle contains a path for listing all available user guides. This path is not secured by default.  
All routes are starting with ``/userguide/`` and are named with ``userguide_``.

### Templates
``javascript_loader.html.twig`` Holds the Script-Tag for the userguide.js and the auto-continue of the userguide. (Loaded by ``userGuideJavascript()``)
``tooltip.html.twig`` Is the displayed tooltip of the userguide

### Styles
All styles are located in the ``css/userguide.css`` file. Just override the styles in your own css file.  
Alternatively you can override the template and include your own styles.



# TODO INFOS FÜR MICH 


endswith: [id$=foo]
startswith[id^=foo]

override tooltip.html.twig
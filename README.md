**The plugin was beta version - use it at your own risk.**

**The plugin is not maintained anymore. We're publishing the code for the community. Forks and maintainers are welcomed.**

## Introduction
PowerComponents plugin is a OctoberCMS plugin with set of traits and classes for components that moves working with components to a next level.

The plugin heavily uses OctoberCMS's AJAX framework. All "empowered" components requests server for views, so it is not possible, to use the plugin without October's AJAX framework. It is a very important thing in some environments to consider.

## Description
This plugin is trying to mimic the backend behavior of creating lists and forms in components. While developing applications is a very common task to create pages with records list and form to preview, create and update records (CRUDs). Secondly we always have to keep in mind the frontend theme. In this case PowerComponents is the way to go.

This plugin heavily uses classes and features from OctoberCMS's core and we are doing our best for it to do all those fancy things the backend can. Sometimes those things need to be done a little different, but in most cases October's docs should apply.

October's docs on:
* [list columns](https://octobercms.com/docs/backend/lists#column-options)
* [form fields](https://octobercms.com/docs/backend/forms#form-field-options)

## Prepare environment
1. Install PowerComponents from MarketPlace
1. Include necessary tags to your layout:
  1. `initbiz/powercomponents/assets/ui/storm.css`
  1. `{% styles %}`
  1. `jquery`
  1. `bootstrap.js`
  1. `initbiz/powercomponents/assets/js/powercomponents.js`
  1. `{% framework extras %}`

For example:

```html
<head>
    <!-- Add PowerComponent Storm UI -->
    <link href="{{ ['$/initbiz/powercomponents/assets/ui/storm.css']|theme }}" rel="stylesheet">
    <!-- Don't forget about additional styles -->
    {% styles %}
    <!-- load jQuery in head section -->
    <script src="{{ ['@jquery'] |theme }}"></script>
</head>

...
<!-- Official bootstrap.js link -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!-- load PowerComponents JS, somewhere between jQuery and Framework -->
<script src="/plugins/initbiz/powercomponents/assets/js/powercomponents.js"> </script>
<!-- October's AJAX Framework -->
{% framework %}
{% framework extras %}
<!-- Don't forget about additional scripts -->
{% scripts %}
```

## Start with creating your first CRUD
Run `php artisan pc:util create crud Initbiz.ExamplePlugin Client` and answer `yes` to all questions.

**DONE! :)**


After running the command you will have:

Created and registered components in `Initbiz.ExamplePlugin` plugin:
* `ClientCreate`
* `ClientUpdate`
* `ClientPreview`
* `ClientList`

Created pages in active theme with following URLs:
* `/clients` - which shows list of clients
* `/clients/create` - which renders the 'create client' form
* `/clients/:id/preview` - which renders the 'preview client' form
* `/clients/:id/update` - which renders the 'update client' form

<a name="feature-overview"></a> <div class="m-t-3 m-b-2"></div>
## Feature overview

<a name="artisan-commands"></a> <div class="m-t-3 m-b-2"></div>
### Artisan commands
PowerComponents registers `pc:util` (as Power Components Utility) command with the following parameters:

#### Create components
```bash
create components <pluginCode>.<pluginName> <modelName>
# For example:
create components October.Test Person
```

The command creates `createPerson`, `updatePerson`, `previewPerson` and `listPerson` components, which are called `crud components` in this documentation.

#### Create sites
```bash
create sites <modelName> [urlprefix]
# For example:
create sites Person
```

The command creates sites in active theme that has embedded `crud components` the components and optional prefix for URL.

#### Register component
```bash
register component <pluginCode>.<pluginName> <componentCode>
# For example:
register component October.Test PersonCreate
```

The command registers `ComponentCode` component in plugin's `Plugin.php` file.

**Note:** The command is parsing the `Plugin.php` as a text file. It backs up the `Plugin.php` file as `Plugin.php.bak` before saving the new version of `Plugin.php` file in case of messing the syntax or doing something unintentional.

The supported syntax of the `Plugin.php` register methods is for example:

```php
public method registerComponents()
{
    return [
       'Class' => 'ComponentCode',
       'Class2' => 'ComponentCode2',
    ];
}
```

The command works with empty `return [];` and no method as well.


#### Create CRUD
```bash
create crud <pluginCode>.<pluginName> <modelName> [urlprefix]
# For example:
create crud October.Test Person
```

The command combines all the foregoing methods, so it:
1. Creates crud components and registers them in plugin
1. Creates crud sites with those components embedded

**Note:** The `create crud` command will ask you if you want to create plugin and model if they do not exist.

<a name="developing-components"></a> <div class="m-t-3 m-b-2"></div>
### Developing components
Controllers differ from components. As a consequence, we cannot treat a component as a controller and give it power to render lists and forms in one class as it is done in backend.

In frontend we have to use one component for one purpose. As a consequence there are two classes that extend ComponentBase class:

1. ListComponentBase
2. FormComponentBase

Their major task is to implement AJAX handlers for the components and they implement all methods that are required by OctoberCMS.

#### Example, minimal component
Take a look at the minimal component configuration that renders the form:

`PersonCreate.php`:

```php
<?php namespace October\Test\Components;

use Initbiz\PowerComponents\Classes\FormComponentBase;

class PersonCreate extends FormComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'PersonCreate Component',
            'description' => 'Component rendering create form for Person'
        ];
    }

}
```

`personcreate/config_form.yaml`:

```yaml
modelClass: October\Test\Models\Person

form:
    fields:
        name:
            label: Name
            commentAbove: Text field, required. Given name in the first box, preferred name in the second box.

        is_married:
            label: Married
            type: dropdown
            emptyOption: Unknown
            options:
                '0': No
                '1': Yes
```

`personcreate/default.htm`:

```twig
<h2>Create person</h2>
{{ form_open() }}
    {{ pcrender('form', attribute(pcViewBag, __SELF__.alias) ) }}
{{ form_close() }}

```

Right now all fields of form are defined in `config_form.yaml` file exact the same way as in backend and normal HTML in `default.htm` with `pcrender` `twig` method.


For list the `pcrender` method in `.htm` file should be invoked as follows:
```twig
{{ pcrender('list', attribute(pcViewBag, __SELF__.alias) ) }}
```

<a name="overriding-views"></a> <div class="m-t-3 m-b-2"></div>
### Overriding views
You can override every view, or its part creating file with the same name as view you want to override. Check the name of the partial you want to override in `/plugins/initbiz/powercomponents/frontendwidgets` or `/plugins/initbiz/powercomponents/frontendformwidgets` directories. For example if you want to override whole list or form, then override `_list.htm` or `_form.htm` partial.

1. **If you want to override view in a component**, then create the partial file in component's views directory.
1. **If you want to override view theme wide**, then create `pcviews` directory in theme's root directory and then create the partial file in it.

Of course files defined in component have higher priority than those defined in theme.

**Note: sometimes overriding views needs to take time because of cache.**

While working with the views, the first thing to understand is that in component (using Twig) you are running method that requests views using AJAX framework. Then the server is rendering partials and responses to AJAX framework, which updates the partial.

**As a consequence, the partials rendered by server are written in PHP (like those in backend), not Twig**. Views written in PHP is a good idea in this case, because those will be edited by developers rather than end users. You have to remember only one rule while writing views in PHP: **Avoid logic in views. There should be only `if`s, `for`s, `foreach`s and `echo`s.**

<a name="integrations"></a> <div class="m-t-3 m-b-2"></div>
## Integrations
PowerComponents can be integrated with another plugins.

<a name="cumulus"></a> <div class="m-t-3 m-b-2"></div>
### Cumulus
If you do not know what `Cumulus` is, than visit [this page](http://cumulus.init.biz/).

Using the `CumulusIntegrator` trait in your component your lists will be by default filtered by cluster using the `cluter_slug` field in database and forms will be feeded with field containing cluster's slug, and it will check if user can view, add or update records that are not in current cluster.

This way, every model wrapped by the PowerComponents will be available only for the cluster that user is currently in (for example one cluster will not be able to read or update clients of the second cluster).

<a name="features-list"></a> <div class="m-t-3 m-b-2"></div>
## Features list

See our forks of `RainLab`'s [Demo theme](https://github.com/initbizlab/pc-demo-theme) and [Test plugin](https://github.com/initbizlab/pc-test-plugin) that show things you can do with Power Components. The list is getting bigger day by day :)

### Integrations
1. Cumulus integration verifying user access to data and filtering lists using cluster's slug from URL

### Console commands
1. `create components Initbiz.ExamplePlugin Model` - creating crud components for Model
1. `create sites Model [urlprefix]` - creating sites in active theme with crud components embedded
1. `register component Initbiz.ExamplePlugin ComponentCode` - registering component in plugin registration file
1. `create crud Initbiz.ExamplePlugin Model [urlprefix]` - combining all the foregoing


<a name="future-plans"></a> <div class="m-t-3 m-b-2"></div>
## Future plans
1. Test, test, test, and test (stable still waiting) with better automatic tests
1. Simplify the code (too much responsibility of classes)
1. Merge some PoweComponents traits with October's core and remove them from plugin (remove the second group of traits)
1. Console command to automatically create yaml files using model properties

<a name="translations"></a> <div class="m-t-3 m-b-2"></div>
## Translations
Remember that translations of plugin are not translations of your components. Translations of plugin mostly mean translation of inspector's properties, it's description, name and so on.

Labels in forms and column names are defined in your `yaml` file, because they are not related with PowerComponents itself.

When it comes to texts in buttons, they are defined in PowerComponents `lang` directory. If you want to have your language available on marketplace, then please send us your translation. We cannot guarantee you full support of your language (we are just developers ;)).

<a name="powercomponents-assets"></a> <div class="m-t-3 m-b-2"></div>
## PowerComponents's assets (CSSs, JSs)

Storm UI used in PowerComponents is a smaller version of OctoberCMS's Storm UI. I was doing my best to compile the file the way it will not mess your themes CSS, but I cannot guarantee it will be the case.

While developing themes try to avoid classes that can collide with those defined in OctoberCMS's Storm UI and if you find collisions that should not be present, let me know.

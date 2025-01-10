# Configuration

To configure the library you need to do three things:

- Configure the template file path
- Create at least one route
- Create template files for each route

## Configure the template path

To configure the template path, add an element with the key `static-pages` to your template path configuration.
Commonly, this is done in the `getTemplates()` method in _src/App/src/ConfigProvider_, as in the example below.

```php
public function getTemplates() : array
{
    return [
        'paths' => [
            'static-pages' => [
                __DIR__ . '/../templates/static-pages'
            ],
        ],
    ];
}
```

## Create one or more routes

To create static page routes, in your routing table add one or more named routes where:

- The route's handler is `StaticPagesHandler::class`;
- The route's name follows the convention: `static.&lt;template_file_name_minus_file_extension&gt;`

Let's assume that you are adding a route for a privacy page, and that it will render the template file `privacy.phtml`.
To do this, you'd add the following to `config/routes.php`:

```php
$app->get(
    '/privacy',
    StaticPagesHandler::class,
    'static.privacy'
);
```

## Create template files

The file can contain whatever you like, it doesn't matter.
It just needs to be in the format that is used by your application's [templating engine](https://docs.mezzio.dev/mezzio/v3/features/template/intro/).

## That’s It

All being well, this should be all that you need to rapidly serve static content files in your https://docs.mezzio.dev/mezzio/[Mezzio] applications.

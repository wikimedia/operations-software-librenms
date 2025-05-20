# LibreNMS Plugin Interfaces

Plugins for [LibreNMS](https://librenms.org) https://github.com/librenms/librenms

Create a new Laravel Package as described:
https://laravel.com/docs/packages

Require this package

    composer require librenms/plugin-interfaces


Register your plugin with LibreNMS in your provider boot method and check to see if it is enabled:

```php
    public function boot(): void
    {
        $pluginName = 'example-plugin';
        $pluginManager = $this->app->make(\LibreNMS\Interfaces\Plugins\PluginManagerInterface::class);

        $pluginManager->publishHook($pluginName, \LibreNMS\Interfaces\Plugins\MenuEntryHook::class, MenuEntryHook::class);

        if (! $pluginManager->pluginEnabled($pluginName)) {
            return; // if plugin is disabled, don't boot
        }

        // Do regular Laravel Package actions here, such as register routes and views or publish files.
    }
```

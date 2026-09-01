<?php

namespace LibreNMS\Interfaces\Plugins;

interface PluginManagerInterface
{
    /**
     * Publish plugin hook, this is the main way to hook into different parts of LibreNMS.
     * plugin_name should be unique. For internal (user) plugins in the app/Plugins directory, the directory name will be used.
     * Hook type will be the full class name of the hook from app/Plugins/Hooks.
     *
     * @param string $pluginName Interface from LibreNMS\Interfaces\Plugins\Hooks
     * @param string $hookType
     * @param string $implementationClass
     * @return bool
     */
    public function publishHook(string $pluginName, string $hookType, string $implementationClass): bool;

    /**
     * Check if there are any valid hooks
     *
     * @param string $hookType Interface from LibreNMS\Interfaces\Plugins\Hooks
     * @param array $args
     * @param string|null $plugin only for this plugin if set
     * @return bool
     */
    public function hasHooks(string $hookType, array $args = [], ?string $plugin = null): bool;

    /**
     * Coll all hooks for the given hook type.
     * args will be available for injection into the handle method to pass data through
     * settings is automatically injected
     *
     * @param string $hookType
     * @param array $args
     * @param string|null $plugin only for this plugin if set
     * @return array
     */
    public function call(string $hookType, array $args = [], ?string $plugin = null): array;

    /**
     * Get the settings stored in the database for a plugin.
     * One plugin shares the settings across all hooks
     *
     * @param string $pluginName
     * @return array
     */
    public function getSettings(string $pluginName): array;

    /**
     * Save settings array to the database for the given plugin
     *
     * @param string $pluginName
     * @param array $settings
     * @return bool
     */
    public function setSettings(string $pluginName, array $settings): bool;

    /**
     * Check if plugin exists.
     * Does not create a DB entry if it does not exist.
     *
     * @param string $pluginName
     * @return bool
     */
    public function pluginExists(string $pluginName): bool;

    /**
     * Check if plugin of the given name is enabled.
     * Creates DB entry if one does not exist yet.
     *
     * @param string $pluginName
     * @return bool
     */
    public function pluginEnabled(string $pluginName): bool;

    /**
     * Remove plugins that do not have any registered hooks.
     */
    public function cleanupPlugins(): void;
}

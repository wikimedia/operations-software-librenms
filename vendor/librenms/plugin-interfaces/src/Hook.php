<?php


namespace LibreNMS\Interfaces\Plugins;

interface Hook
{
    /**
     * Will be called by the plugin manager to check if the user is authorized. Will be called with Dependency Injection.
     */
//    public function authorize(): bool;

    /**
     * Will be called by the plugin manager to execute this plugin at the correct time. Will be called with Dependency Injection.
     * Available variables for injection: $pluginName, $settings
     *
     */
//    public function handle();
}

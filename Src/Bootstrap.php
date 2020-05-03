<?php
namespace App;

class Bootstrap
{
    const SHORT_CODE = "vue_form"; 

    /**
     * @return void
     */
    public function init()
    {
        $this->load();
        add_shortcode(self::SHORT_CODE, [$this, 'getForm']);
        $this->addEndpoints();
        $this->runDb();
    }

    /**
     * @return string
     */
    public function getForm()
    {
        return '<div id="mount"></div>';
    }

    /**
     * @return void
     */
    private function load()
    {
        $this->enqueueScripts();
        $this->loadIncludes();
    }

    /**
     * @return void
     */
    private function enqueueScripts()
    {
        wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.11', [], '2.6.11');
        wp_enqueue_script('vue-form', plugin_dir_url( __FILE__ ) . 'static/js/form.js', [], '1.0', true);

        wp_enqueue_style('vue-form', plugin_dir_url( __FILE__ ) . 'static/css/vue-form.css', [], '1.0');
    }

    /**
     * @return void
     */
    private function loadIncludes()
    {
        \spl_autoload_register(function($class) {
            $classPath = str_replace(__NAMESPACE__ . '\\', '', $class);
            include __DIR__ . '/' .$classPath . '.php';
        });
    }

    /**
     * @return void
     */
    private function addEndpoints()
    {
        $formApi = new \App\FormApi();
    }

    /**
     * @return void
     */
    private function runDb()
    {
        \App\Setup::execute();
    }
}
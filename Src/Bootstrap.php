<?php
namespace App\Src;

class Bootstrap
{
    const SHORT_CODE = "vue_form"; 

    public function init()
    {
        $this->load();
        add_shortcode(self::SHORT_CODE, [$this, 'getForm']);
    }

    public function getForm()
    {
        return "Hejsan!";
    }

    private function load()
    {
        $this->enqueueScripts();
        $this-loadIncludes();
    }

    private function enqueueScripts()
    {

    }

    private function loadIncludes()
    {

    }
}
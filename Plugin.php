<?php namespace Initbiz\PowerComponents;

use Lang;
use Event;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    use \System\Traits\EventEmitter;

    public function register()
    {
        $this->registerConsoleCommand('pc.crud', 'Initbiz\PowerComponents\Console\PcUtil');
    }

    public function registerFormWidgets()
    {
        return [
            'Initbiz\PowerComponents\FormWidgets\DynamicForm'      => 'dynamicform',
        ];
    }

    public function registerFrontendFormWidgets()
    {
        return [
            'Initbiz\PowerComponents\FrontendFormWidgets\Relation'    => 'relation',
            'Initbiz\PowerComponents\FrontendFormWidgets\Repeater'    => 'repeater',
            'Initbiz\PowerComponents\FrontendFormWidgets\DatePicker'  => 'datepicker',
            // 'Initbiz\PowerComponents\FrontendFormWidgets\CodeEditor'  => 'codeeditor',
            'Initbiz\PowerComponents\FrontendFormWidgets\FileUpload'  => 'fileupload',
            'Initbiz\PowerComponents\FrontendFormWidgets\TagList'     => 'taglist',
            'Initbiz\PowerComponents\FrontendFormWidgets\ColorPicker' => 'colorpicker',
            'Initbiz\PowerComponents\FrontendFormWidgets\DynamicForm' => 'dynamicform',
            'Initbiz\PowerComponents\FrontendFormWidgets\RichEditor'  => 'richeditor',
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'pcrender'          => [$this, 'pcrender']
            ]
        ];
    }

    /**
     * Render part
     * @param string $widgetName to be rendered
     * @param array  $options array containing options of a component
     * @return string
     */
    public function pcrender($widgetName, $options)
    {
        $ajaxHandlerName = '';

        $widgetsWithHandlers = [
            'list' => 'onRefreshList',
            'form' => 'onRefreshForm',
        ];

        $this->fireEvent('pc.handlers.beforePcrender', [$widgetsWithHandlers], false);

        foreach ($widgetsWithHandlers as $name => $handler) {
            if ($widgetName === $name) {
                $ajaxHandlerName = $handler;
                break;
            }
        }

        if ($ajaxHandlerName === '') {
            return 'Unknown widget type';
        }

        $divId = 'pc-'.$widgetName.'-'.$options['componentAlias'];

        return '
        <div id="'.$divId.'" class="empowered-component">
            '.$this->preloaderContent().'
        </div>
        <script>
            $(document).ready(function() {
                $.request(\''.$options['componentAlias'].'::'.$ajaxHandlerName.'\', {
                    data: '.json_encode($options).'
                });
            });
        </script>
        ';
    }

    /**
     * Method returning preloader div content. It will be replaced after successfull AJAX
     * @return string $content to be placed in components div
     */
    public function preloaderContent()
    {
        //TODO: move this one to view file which can be overriden theme wide
        $content = '
        <div class="loading-indicator-container">
            <div class="loading-indicator indicator-center">
                <span></span>
                <div>'.
                Lang::get('initbiz.powercomponents::lang.misc.loader_text')
                .'</div>
            </div>
        </div>
        ';

        Event::fire('pc.frontend.preloader.beforeRender', [&$content]);

        return $content;
    }
}

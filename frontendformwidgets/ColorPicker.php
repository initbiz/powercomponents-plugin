<?php namespace Initbiz\PowerComponents\FrontendFormWidgets;

use Initbiz\PowerComponents\Classes\FrontendFormWidgetBase;

class ColorPicker extends FrontendFormWidgetBase
{
    //
    // Configurable properties
    //

    /**
     * @var array Default available colors
     */
    public $availableColors = [
        '#1abc9c', '#16a085',
        '#2ecc71', '#27ae60',
        '#3498db', '#2980b9',
        '#9b59b6', '#8e44ad',
        '#34495e', '#2b3e50',
        '#f1c40f', '#f39c12',
        '#e67e22', '#d35400',
        '#e74c3c', '#c0392b',
        '#ecf0f1', '#bdc3c7',
        '#95a5a6', '#7f8c8d',
    ];

    /**
     * @var bool Allow empty value
     */
    public $allowEmpty = false;

    /**
     * @var bool Show opacity slider
     */
    public $showAlpha = false;

    //
    // Object properties
    //

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'colorpicker';

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'availableColors',
            'allowEmpty',
            'showAlpha',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('colorpicker');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->getFieldName();
        $this->vars['value'] = $value = $this->getLoadValue();
        $this->vars['availableColors'] = $availableColors = $this->getAvailableColors();
        $this->vars['allowEmpty'] = $this->allowEmpty;
        $this->vars['showAlpha'] = $this->showAlpha;
        $this->vars['isCustomColor'] = !in_array($value, $availableColors);
    }

    /**
     * Gets the appropriate list of colors.
     *
     * @return array
     */
    protected function getAvailableColors()
    {
        $availableColors = $this->availableColors;
        if (is_array($availableColors)) {
            return $availableColors;
        }
        elseif (is_string($availableColors) && !empty($availableColors)) {
            if ($this->model->methodExists($availableColors)) {
                return $this->availableColors = $this->model->{$availableColors}(
                    $this->formField->fieldName,
                    $this->formField->value,
                    $this->formField->config
                );
            } else {
                throw new ApplicationException(Lang::get('backend::lang.field.colors_method_not_exists', [
                    'model'  => get_class($this->model),
                    'method' => $availableColors,
                    'field'  => $this->formField->fieldName
                ]));
            }
        }
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $pluginPath = '~/plugins/initbiz/powercomponents/frontendformwidgets/colorpicker/';

        $this->addCss([$pluginPath.'assets/vendor/spectrum/spectrum.css',
                       $pluginPath.'assets/css/colorpicker.css']);

        $this->addJs(['~/modules/backend/assets/js/vendor/jquery.touchwipe.js',
                      $pluginPath.'assets/vendor/spectrum/spectrum.js',
                      $pluginPath.'assets/js/colorpicker.js']);
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return strlen($value) ? $value : null;
    }
}

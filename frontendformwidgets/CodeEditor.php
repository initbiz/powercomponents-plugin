<?php namespace Initbiz\PowerComponents\FrontendFormWidgets;

use Initbiz\PowerComponents\Classes\FrontendFormWidgetBase;

class CodeEditor extends FrontendFormWidgetBase
{
    //
    // Configurable properties
    //

    /**
     * @var string Code language to display (php, twig)
     */
    public $language = 'php';

    /**
     * @var boolean Determines whether the gutter is visible.
     */
    public $showGutter = true;

    /**
     * @var boolean Indicates whether the the word wrapping is enabled.
     */
    public $wordWrap = true;

    /**
     * @var string Cold folding mode: manual, markbegin, markbeginend.
     */
    public $codeFolding = 'manual';

    /**
     * @var boolean Automatically close tags and special characters,
     * like quotation marks, parenthesis, or brackets.
     */
    public $autoClosing = true;

    /**
     * @var boolean Indicates whether the the editor uses spaces for indentation.
     */
    public $useSoftTabs = true;

    /**
     * @var boolean Sets the size of the indentation.
     */
    public $tabSize = 4;

    /**
     * @var integer Sets the font size.
     */
    public $fontSize = 12;

    /**
     * @var integer Sets the editor margin size.
     */
    public $margin = 0;

    /**
     * @var string Ace Editor theme to use.
     */
    public $theme = 'twilight';

    /**
     * @var bool Show invisible characters.
     */
    public $showInvisibles = false;

    /**
     * @var bool Highlight the active line.
     */
    public $highlightActiveLine = true;

    /**
     * @var boolean If true, the editor is set to read-only mode
     */
    public $readOnly = false;

    /**
     * @var string Autocomplete mode: manual, basic, live.
     */
    public $autocompletion = 'manual';

    /**
     * @var boolean If true, the editor activate use Snippets
     */
    public $enableSnippets = true;

    /**
     * @var boolean If true, the editor show Indent Guides
     */
    public $displayIndentGuides = true;

    /**
     * @var boolean If true, the editor show Print Margin
     */
    public $showPrintMargin = false;

    //
    // Object properties
    //

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'codeeditor';

    /**
     * @inheritDoc
     */
    public function init()
    {
        // $this->applyEditorPreferences();

        if ($this->formField->disabled) {
            $this->readOnly = true;
        }

        $this->fillFromConfig([
            'language',
            'showGutter',
            'wordWrap',
            'codeFolding',
            'autoClosing',
            'useSoftTabs',
            'tabSize',
            'fontSize',
            'margin',
            'theme',
            'showInvisibles',
            'highlightActiveLine',
            'readOnly',
            'autocompletion',
            'enableSnippets',
            'displayIndentGuides',
            'showPrintMargin'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('codeeditor');
    }

    /**
     * Prepares the widget data
     */
    public function prepareVars()
    {
        $this->vars['fontSize'] = $this->fontSize;
        $this->vars['wordWrap'] = $this->wordWrap;
        $this->vars['codeFolding'] = $this->codeFolding;
        $this->vars['autoClosing'] = $this->autoClosing;
        $this->vars['tabSize'] = $this->tabSize;
        $this->vars['theme'] = $this->theme;
        $this->vars['showInvisibles'] = $this->showInvisibles;
        $this->vars['highlightActiveLine'] = $this->highlightActiveLine;
        $this->vars['useSoftTabs'] = $this->useSoftTabs;
        $this->vars['showGutter'] = $this->showGutter;
        $this->vars['language'] = $this->language;
        $this->vars['margin'] = $this->margin;
        $this->vars['stretch'] = $this->formField->stretch;
        $this->vars['size'] = $this->formField->size;
        $this->vars['readOnly'] = $this->readOnly;
        $this->vars['autocompletion'] = $this->autocompletion;
        $this->vars['enableSnippets'] = $this->enableSnippets;
        $this->vars['displayIndentGuides'] = $this->displayIndentGuides;
        $this->vars['showPrintMargin'] = $this->showPrintMargin;

        // Double encode when escaping
        $this->vars['value'] = htmlentities($this->getLoadValue(), ENT_QUOTES, 'UTF-8', true);
        $this->vars['name'] = $this->getFieldName();
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $widgetPath = '~/plugins/initbiz/powercomponents/frontendformwidgets/colorpicker/';

        $this->addCss(
            [$widgetPath.'css/codeeditor.css']
        );
        $this->addJs(
            [$widgetPath.'js/build-min.js']
        );
    }
}

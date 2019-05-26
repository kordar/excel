<?php

namespace kordar\excel;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use yii\base\InvalidConfigException;

/**
 * Class BaseListSheet
 * @package kordar\excel
 */
abstract class BaseListSheet extends \yii\base\BaseObject
{
    /**
     * @var Worksheet
     */
    public $sheet;

    /**
     * @var \yii\data\DataProviderInterface the data provider for the view. This property is required.
     */
    public $dataProvider;

    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{header}`: the list items. See [[renderHeader()]].
     * - `{body}`: the sorter. See [[renderBody()]].
     * - `{footer}`: the sorter. See [[renderFooter()]].
     */
    public $layout = "{header}\n{body}\n{footer}";


    /**
     * Renders the data models.
     * @return string the rendering result.
     */
    abstract public function renderHeader();

    /**
     * @return mixed
     */
    abstract public function renderBody();

    /**
     * @return mixed
     */
    abstract public function renderFooter();

    /**
     * Initializes the view.
     */
    public function init()
    {
        parent::init();
        if ($this->dataProvider === null) {
            throw new InvalidConfigException('The "dataProvider" property must be set.');
        }
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        if ($this->dataProvider->getCount() > 0) {
            preg_replace_callback('/{\\w+}/', function ($matches) {
                $this->renderSection($matches[0]);
            }, $this->layout);
        }
    }

    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
     * @return string|bool the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{summary}':
                return $this->renderSummary();
            case '{header}':
                return $this->renderHeader();
            case '{body}':
                return $this->renderBody();
            case '{footer}':
                return $this->renderFooter();
            default:
                return false;
        }
    }

    /**
     * Renders the summary text.
     */
    public function renderSummary()
    {
        return true;
    }
}
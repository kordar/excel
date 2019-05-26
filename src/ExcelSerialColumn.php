<?php

namespace kordar\excel;

/**
 * SerialColumn displays a column of row numbers (1-based).
 *
 * To add a SerialColumn to the [[GridView]], add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => 'yii\grid\SerialColumn',
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * For more details and usage information on SerialColumn, see the [guide article on data widgets](guide:output-data-widgets).
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ExcelSerialColumn extends \yii\grid\Column
{
    /**
     * {@inheritdoc}
     */
    public $header = '#';

    /**
     * @return string
     */
    public function renderHeaderCell()
    {
        return $this->renderHeaderCellContent();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $pagination = $this->grid->dataProvider->getPagination();
        if ($pagination !== false) {
            return $pagination->getOffset() + $index + 1;
        }

        return $index + 1;
    }

    public function renderDataCell($model, $key, $index)
    {
        return $this->renderDataCellContent($model, $key, $index);
    }
}

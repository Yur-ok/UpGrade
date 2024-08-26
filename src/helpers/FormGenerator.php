<?php

namespace app\helpers;

use yii\base\Model;
use yii\helpers\Html;

class FormGenerator
{
    /**
     * @param Model $model
     * @return string HTML-код формы
     */
    public static function generateForm(Model $model): string
    {
        $formHtml = Html::beginForm('', 'post');

        foreach ($model->attributes() as $attribute) {
            // Создаем поля ввода для каждого атрибута модели
            if ($attribute !== 'title' && $attribute !== 'description') {
                continue;
            }
            $formHtml .= '<div class="form-group">';
            $formHtml .= Html::label(ucfirst($attribute), $attribute);
            $formHtml .= Html::textInput("Goal[$attribute]", $model->$attribute, ['class' => 'form-control']);
            $formHtml .= '</div>';
        }

        // Кнопка отправки формы
        $formHtml .= Html::submitButton('Save', ['class' => 'btn btn-primary']);

        // Конец формы
        $formHtml .= Html::endForm();

        return $formHtml;
    }
}

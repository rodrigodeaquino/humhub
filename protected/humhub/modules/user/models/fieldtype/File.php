<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\models\fieldtype;

use Yii;

/**
 * ProfileFieldTypeFile handles file fields.
 *
 * @package humhub.modules_core.user.models
 * @since 0.5
 */
class File extends BaseType
{

    /**
     * Field Default File
     *
     * @var String
     */
    public $default;

    /**
     * Rules for validating the Field Type Settings Form
     *
     * @return type
     */
    public function rules()
    {
        return array(
       );
    }

    /**
     * Returns Form Definition for edit/create this field.
     *
     * @return Array Form Definition
     */
    public function getFormDefinition($definition = array())
    {
        return parent::getFormDefinition(array(
                    get_class($this) => array(
                        'type' => 'form',
                        'title' => Yii::t('UserModule.models_ProfileFieldTypeFile', 'File Field Options'),
                        'elements' => array(
                        )
        )));
    }

    /**
     * Saves this Profile Field Type
     */
    public function save()
    {
        $columnName = $this->profileField->internal_name;
        if (!\humhub\modules\user\models\Profile::columnExists($columnName)) {
            $query = Yii::$app->db->getQueryBuilder()->addColumn(\humhub\modules\user\models\Profile::tableName(), $columnName, 'VARCHAR(255)');
            Yii::$app->db->createCommand($query)->execute();
        }

        return parent::save();
    }

    /**
     * @inheritdoc
     */
    public function getFieldFormDefinition()
    {
        return array($this->profileField->internal_name => array(
                'type' => 'file',
                'class' => 'form-control'
        ));
    }

    public function getUserValue($user, $raw = true)
    {
        $internalName = $this->profileField->internal_name;
        $value = $user->profile->$internalName;

        return \yii\helpers\Html::encode($value);
    }

}

?>


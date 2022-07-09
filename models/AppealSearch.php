<?php

namespace app\modules\models;

use app\modules\models\Appeal;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class AppealSearch extends Appeal
{
    public $pageSize = 10; 
    public $search;

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            ['surname','string'],
            ['name','string'],
            ['patronymic','string'],
            ['email','string'],
            ['phoneNumber','string'],
            ['pageSize','safe']
        ]);
    }

    public function search($params)
    {
        if(array_key_exists('query', $params)){
            $this->search = iconv_substr($params['query'], 0, 64);
            $this->search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ@.]#u', ' ', $this->search);
            $this->search = preg_replace('#\s+#u', ' ', $this->search);
            $this->search = trim($this->search);
        }
        else{
            $this->search = null;
        }

        $query = static::find();
        //var_dump($this->search);die();
        if (!empty($this->search)) {
            $words = explode(' ', $this->search);
            $query = self::find()
                ->where(['like', 'surname', '%'.$words[0].'%', false])
                ->orWhere(['like', 'name', '%'.$words[0].'%', false])
                ->orWhere(['like', 'patronymic', '%'.$words[0].'%', false])
                ->orWhere(['like', 'phoneNumber', '%'.$words[0].'%', false])
                ->orWhere(['like', 'email', '%'.$words[0].'%', false]);

            for ($i = 1; $i < count($words); $i++) {
                $query = $query->orWhere(['like', 'surname', '%'.$words[$i].'%', false])
                    ->orWhere(['like', 'name', '%'.$words[$i].'%', false])
                    ->orWhere(['like', 'patronymic', '%'.$words[$i].'%', false])
                    ->orWhere(['like', 'phoneNumber', '%'.$words[$i].'%', false])
                    ->orWhere(['like', 'email', '%'.$words[$i].'%', false]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'Pagination' => [
                'defaultPageSize' => 10,
                'pageSize' => $this->pageSize
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}
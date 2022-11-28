<?php

namespace app\modules\feedback\models\appeals;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\feedback\models\appeals\Appeal;

class AppealSearch extends Model 
{
    public $fullName;
    public $search = '';
    public $pageSize;

    public function rules()
    {
        return [
            ['search', 'required', 'message' => 'Заполните поле'],
            ['search', 'string', 'max' => 255, 'tooLong' => 'Максимальное количество доступных для ввода символов: {max}.'],
            [['pageSize'],'safe'],
            [['fullName'], 'safe']
        ];
    }

    public static function itemsPerPage()
    {
        return array(
            10 => 10,
            20 => 20,
            50 => 50,
            100 => 100
        );
    }
    
    public function search($params) {
        if(array_key_exists('query', $params)) {
            $this->search = iconv_substr($params['query'], 0, 64);
            $this->search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ@.]#u', ' ', $this->search);
            $this->search = preg_replace('#\s+#u', ' ', $this->search);
            $this->search = trim($this->search);
        }
        else {
            $this->search = null;
        }
        
        $query = Appeal::find();

        if ($this->validate()) {
            $words = explode(' ', $this->search);

            if(count($words) === 1){
                $query->orWhere('surname LIKE "%'.$words[0].'%" '.
                    'OR name LIKE "%'.$words[0].'%" '.
                    'OR patronymic LIKE "%'.$words[0].'%"'
                )
                ->orWhere(['like', 'phoneNumber', '%'.$words[0].'%', false])
                ->orWhere(['like', 'email', '%'.$words[0].'%', false]);
            }
            else{
                for ($i = 0; $i < count($words); $i++) {
                    $query = $query->andWhere('surname LIKE "%'.$words[$i].'%" '.
                        'OR name LIKE "%'.$words[$i].'%" '.
                        'OR patronymic LIKE "%'.$words[$i].'%"'
                    );
                }
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => array_key_first(self::itemsPerPage()),
                'pageSizeLimit' => [1, array_key_last(self::itemsPerPage())],
                'pageSize' => $this->pageSize,
                'forcePageParam' => false,
                'pageSizeParam' => 'per-page'
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ],
                'attributes' => [
                    'id',
                    'fullName' => [
                        'asc' => ['surname' => SORT_ASC, 'name' => SORT_ASC, 'patronymic' => SORT_ASC],
                        'desc' => ['surname' => SORT_DESC, 'name' => SORT_DESC, 'patronymic' => SORT_DESC],
                        'label' => 'ФИО',
                        'default' => SORT_ASC
                    ],
                    'phoneNumber',
                    'date' => [
                        'asc' => ['date' => SORT_ASC, 'time' => SORT_ASC],
                        'desc' => ['date' => SORT_DESC, 'time' => SORT_DESC],
                        'default' => SORT_ASC
                    ]
                ]
            ],
        ]);    

        return $dataProvider;

    }
}
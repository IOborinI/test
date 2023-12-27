<?php

namespace api\models;

use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentsSearch represents the model behind the search form of `common\models\Comments`.
 */
class CommentSearch extends Comment
{
    public $username;
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['title', 'description', 'username',], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->setAttributes($params, true);
        $query = Comment::find()
            ->joinWith('user');

        $query->select(['comment.*', 'user.username as username']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            'asc' => ['username' => SORT_ASC],
            'desc' => ['username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'comment.title', $this->title])
            ->andFilterWhere(['like', 'comment.description', $this->description])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}

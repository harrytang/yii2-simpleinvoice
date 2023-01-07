<?php

namespace harrytang\simpleinvoice\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use harrytang\simpleinvoice\models\Invoice as InvoiceModel;

/**
 * Invoice represents the model behind the search form about `harrytang\simpleinvoice\models\Invoice`.
 */
class Invoice extends InvoiceModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'email', 'contact', 'sold_to', 'ship_to', 'payment_methods', 'shipping_carrier', 'details'], 'safe'],
            [['payment_status', 'shipping_status', 'status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = InvoiceModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'payment_status' => $this->payment_status,
            'shipping_status' => $this->shipping_status,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'sold_to', $this->sold_to])
            ->andFilterWhere(['like', 'ship_to', $this->ship_to])
            ->andFilterWhere(['like', 'payment_methods', $this->payment_methods])
            ->andFilterWhere(['like', 'shipping_carrier', $this->shipping_carrier])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}

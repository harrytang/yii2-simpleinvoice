<?php

namespace harrytang\simpleinvoice\models;

use harrytang\simpleinvoice\SimpleinvoiceModule;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%simpleinvoice_invoice}}".
 *
 * @property string $id
 * @property string $currency
 * @property string $email
 * @property string $contact
 * @property string $sold_to
 * @property string $ship_to
 * @property string $payment_methods
 * @property integer $payment_status
 * @property integer $payment_date
 * @property string $shipping_carrier
 * @property integer $shipping_status
 * @property integer $shipping_date
 * @property resource $proof_of_shipment
 * @property resource $invoice_pdf
 * @property resource $img_1
 * @property resource $img_2
 * @property resource $img_3
 * @property string $details
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Invoice extends ActiveRecord
{

    const STATUS_ACTIVE = 10;

    const SHIPPING_STATUS_PENDING = 10;
    const SHIPPING_STATUS_SHIPPED = 20;
    const SHIPPING_STATUS_PARTIAL_SHIPPED = 30;


    const PAYMENT_STATUS_PENDING = 10;
    const PAYMENT_STATUS_PAID = 20;

    public $proof_of_shipment_file;
    public $invoice_pdf_file;

    public $img_1_file;
    public $img_2_file;
    public $img_3_file;

    /**
     * get status list
     * @param null $e
     * @return array
     */
    public static function getStatusOption($e = null)
    {
        $option = [
            self::STATUS_ACTIVE => SimpleinvoiceModule::t('Active'),
        ];
        if (is_array($e))
            foreach ($e as $i)
                unset($option[$i]);
        return $option;
    }

    /**
     * get invoice status
     * @param null $status
     * @return string
     */
    public function getStatusText($status = null)
    {
        if ($status === null) {
            $status = $this->status;
        }
        switch ($status) {
            case self::STATUS_ACTIVE:
                return SimpleinvoiceModule::t('Active');
                break;
        }
        return SimpleinvoiceModule::t('Unknown');
    }

    /**
     * get shipping status text
     * @param null $status
     * @return mixed
     */
    public function getShippingStatusText($status = null)
    {
        if ($status === null)
            $status = $this->shipping_status;
        switch ($status) {
            case self::SHIPPING_STATUS_PENDING:
                return SimpleinvoiceModule::t('Pending');
                break;
            case self::SHIPPING_STATUS_SHIPPED:
                return SimpleinvoiceModule::t('Shipped');
                break;
            case self::SHIPPING_STATUS_PARTIAL_SHIPPED:
                return SimpleinvoiceModule::t('Partial Shipped');
                break;

        }
        return SimpleinvoiceModule::t('Unknown');
    }

    /**
     * get shipping status option
     * @param null $e
     * @return array
     */
    public static function getShippingStatusOption($e = null)
    {
        $option = [
            self::SHIPPING_STATUS_PENDING => SimpleinvoiceModule::t('Pending'),
            self::SHIPPING_STATUS_SHIPPED => SimpleinvoiceModule::t('Shipped'),
            self::SHIPPING_STATUS_PARTIAL_SHIPPED => SimpleinvoiceModule::t('Partial Shipped'),
        ];
        if (is_array($e))
            foreach ($e as $i)
                unset($option[$i]);
        return $option;
    }

    /**
     * get payment status text
     * @param null $status
     * @return mixed
     */
    public function getPaymentStatusText($status = null)
    {
        if ($status === null) {
            $status = $this->payment_status;
        }
        switch ($status) {
            case self::PAYMENT_STATUS_PENDING:
                return SimpleinvoiceModule::t('Pending');
                break;
            case self::PAYMENT_STATUS_PAID:
                return SimpleinvoiceModule::t('Paid');
                break;
        }
        return SimpleinvoiceModule::t('Unknown');
    }

    /**
     * get payment status option
     * @param null $e
     * @return array
     */
    public static function getPaymentStatusOption($e = null)
    {
        $option = [
            self::PAYMENT_STATUS_PENDING => SimpleinvoiceModule::t('Pending'),
            self::PAYMENT_STATUS_PAID => SimpleinvoiceModule::t('Paid'),
        ];
        if (is_array($e))
            foreach ($e as $i)
                unset($option[$i]);
        return $option;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%simpleinvoice_invoice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency', 'email', 'contact', 'sold_to', 'ship_to', 'payment_status', 'shipping_status', 'details', 'status'], 'required'],
            [['sold_to', 'ship_to', 'details'], 'string'],
            [['payment_status', 'payment_date', 'shipping_status', 'payment_date', 'status', 'created_at', 'updated_at'], 'integer'],
            [['id'], 'string', 'max' => 20],
            [['email', 'payment_methods', 'shipping_carrier'], 'string', 'max' => 255],
            [['contact'], 'string', 'max' => 50],
            [['email'], 'email'],

            [['proof_of_shipment_file', 'invoice_pdf_file', 'img_1', 'img_2', 'img_3'], 'safe'],
            [['proof_of_shipment_file', 'img_1', 'img_2', 'img_3'], 'file', 'extensions' => 'png, jpg'],
            [['invoice_pdf_file'], 'file', 'extensions' => 'pdf']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => SimpleinvoiceModule::t('ID'),
            'currency' => SimpleinvoiceModule::t('Currency'),
            'email' => SimpleinvoiceModule::t('Email'),
            'contact' => SimpleinvoiceModule::t('Contact'),
            'sold_to' => SimpleinvoiceModule::t('Sold To'),
            'ship_to' => SimpleinvoiceModule::t('Ship To'),
            'payment_methods' => SimpleinvoiceModule::t('Payment Methods'),
            'payment_status' => SimpleinvoiceModule::t('Payment Status'),
            'payment_date' => SimpleinvoiceModule::t('Payment Date'),
            'shipping_carrier' => SimpleinvoiceModule::t('Shipping Carrier'),
            'shipping_status' => SimpleinvoiceModule::t('Shipping Status'),
            'shipping_date' => SimpleinvoiceModule::t('Shipping Date'),

            'proof_of_shipment' => SimpleinvoiceModule::t('Proof Of Shipment'),
            'invoice_pdf' => SimpleinvoiceModule::t('PDF Invoice'),
            'img_1' => SimpleinvoiceModule::t('Picture 1'),
            'img_2' => SimpleinvoiceModule::t('Picture 2'),
            'img_3' => SimpleinvoiceModule::t('Picture 3'),

            'details' => SimpleinvoiceModule::t('Details'),
            'status' => SimpleinvoiceModule::t('Status'),
            'created_at' => SimpleinvoiceModule::t('Created At'),
            'updated_at' => SimpleinvoiceModule::t('Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        parent::beforeSave($insert);


        if ($this->shipping_status == self::SHIPPING_STATUS_SHIPPED && empty($this->shipping_date)) {
            $this->touch('shipping_date');
        }
        if ($this->payment_status == self::PAYMENT_STATUS_PAID && empty($this->payment_date)) {
            $this->touch('payment_date');
        }
        if ($insert) {
            $this->id = rand('100', '999') . time() . rand('100', '999');

        }

        return true;
    }

    /**
     * After save
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            //$this->sendMail();
        } else {
            $changes = '';
            $forceSendUpdate=false;


            foreach ($changedAttributes as $key => $value) {
                $attrs=[
                    'payment_status',
                    'shipping_status',
                    'details'
                ];
                if (in_array($key, $attrs) && $value != $this->$key) {
                    if($key=='details'){
                        $forceSendUpdate=true;
                    }

                    if($key=='payment_status'){
                        //$newValue=$this->getPaymentStatusText();
                        if($this->payment_status==Invoice::PAYMENT_STATUS_PAID)
                        {
                            $changes.=SimpleinvoiceModule::t('We have received your payment on {DATE}', ['DATE'=>Yii::$app->formatter->asDate($this->payment_date)]);
                        }
                    }
                    if($key=='shipping_status'){
                        //$newValue=$this->getShippingStatusText();
                        if($this->shipping_status!=Invoice::SHIPPING_STATUS_PENDING)
                        {
                            $changes.=SimpleinvoiceModule::t('Your plastic has been shipped');
                        }
                    }

                    //$changes .= SimpleinvoiceModule::t('- {ATTR} has changed to: {NEW_VALUE}', ['ATTR' => $this->getAttributeLabel($key), 'NEW_VALUE' => $newValue]) . '<br/>';
                }

            }

            if(!empty($changes) or $forceSendUpdate) {
                $this->sendUpdate($changes);
            }
        }


    }

    /**
     * get invoice ID with separators
     * @return string
     */
    public function getIdWithSeparator()
    {
        $id = $this->id;

        // GET THE LENGTH
        $length = strlen($id);


        $new = substr($id, -4);

        for ($i = $length - 5; $i >= 0; $i--) {
            // ADDS HYPHEN HERE
            if ((($i + 1) - $length) % 4 == 0) {
                $new = '-' . $new;
            }
            $new = $id[$i] . $new;
        }

        return $new;
    }

    /**
     * get invoice url
     * @param bool $absolute
     * @return mixed
     */
    public function getUrl($absolute = true)
    {
        $act = 'createAbsoluteUrl';
        if ($absolute !== true) {
            $act = 'createUrl';
        }
        return Yii::$app->urlManager->$act(['simpleinvoice/invoice/view', 'id' => $this->id]);
    }

    /**
     * send invoice via email
     */
    public function sendMail()
    {
        $subject = SimpleinvoiceModule::t("You've received an invoice ({INVOICE_ID}) from {APP}", [
            'INVOICE_ID' => $this->getIdWithSeparator(),
            'APP' => Yii::$app->name,
        ]);
        $mailer= \Yii::$app->mailer->compose('newInvoice', ['invoice' => $this])
            ->setFrom([\Yii::$app->params['settings']['supportEmail'] => \Yii::$app->name])
            ->setTo($this->email)
            ->setBcc('harry@vietplastic.com')
			->setBcc('peter@vietplastic.com')
            ->setSubject($subject);
        if(!empty($this->invoice_pdf)){
            $mailer->attachContent($this->invoice_pdf, [
                'fileName'=>'invoice-'.$this->getIdWithSeparator().'.pdf',
                'contentType'=>'application/pdf'
            ]);
        }
        if(!empty($this->img_1)){
            $mailer->attachContent($this->img_1, [
                'fileName'=>'IMG1.JPG',
                'contentType'=>'image/jpeg'
            ]);
        }
        if(!empty($this->img_2)){
            $mailer->attachContent($this->img_2, [
                'fileName'=>'IMG2.JPG',
                'contentType'=>'image/jpeg'
            ]);
        }
        if(!empty($this->img_3)){
            $mailer->attachContent($this->img_3, [
                'fileName'=>'IMG3.JPG',
                'contentType'=>'image/jpeg'
            ]);
        }
        $mailer->send();
    }

    /**
     * send invoice update via email
     * @param $changes
     */
    protected function sendUpdate($changes)
    {
        $subject = SimpleinvoiceModule::t("Updates for your invoice ({ID}) from {APP}", [
            'APP' => Yii::$app->name,
            'ID'=>$this->getIdWithSeparator()
        ]);
        $mailer= \Yii::$app->mailer->compose('updateInvoice', ['invoice' => $this, 'changes' => $changes])
            ->setFrom([\Yii::$app->params['settings']['supportEmail'] => \Yii::$app->name])
            ->setTo($this->email)
            ->setBcc('harry@vietplastic.com')
			->setBcc('peter@vietplastic.com')
            ->setSubject($subject);

        if(!empty($this->proof_of_shipment)){
            $mailer->attachContent($this->proof_of_shipment, [
                'fileName'=>'proof_of_shipment.jpg',
                'contentType'=>'image/jpeg'
            ]);
        }
        if($mailer->send()){
            Yii::$app->session->setFlash('success', 'Email has been sent.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Error while sending email.');
        }
    }

    /**
     * get invoice total
     * @return int
     */
    public function getTotal(){
        $sum['subtotal'] = 0;
        $sum['tax'] = 0;
        $sum['total'] = 0;

        /* items */
        $items = [];
        $lines = explode("\n", $this->details);
        foreach ($lines as $i => $line) {
            list($product, $price, $quantity, $shipped) = explode('|', $line);
            $items[$i]['product'] = trim($product);
            $items[$i]['price'] = trim($price);
            $items[$i]['quantity'] = trim($quantity);
            $items[$i]['shipped'] = trim($shipped);
            $items[$i]['extended_price'] = $quantity * $price;
            $sum['subtotal'] += $items[$i]['extended_price'];
        }
        /* Subtotal */
        $sum['total'] = $sum['subtotal'] + $sum['tax'];
        return $sum['total'];
    }

    /**
     * get invoice items
     * @return array
     */
    public function getItems(){
        /* items */
        $items = [];
        $lines = explode("\n", $this->details);
        foreach ($lines as $i => $line) {
            list($product, $price, $quantity, $shipped) = explode('|', $line);
            $items[$i]['product'] = trim($product);
            $items[$i]['price'] = trim($price);
            $items[$i]['quantity'] = trim($quantity);
            $items[$i]['shipped'] = trim($shipped);
        }
        return $items;
    }
}

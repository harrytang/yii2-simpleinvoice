<?php

namespace harrytang\simpleinvoice\controllers;

use harrytang\simpleinvoice\SimpleinvoiceModule;
use Yii;
use harrytang\simpleinvoice\models\Invoice;
use harrytang\simpleinvoice\models\search\Invoice as InvoiceSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['email', 'index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['staff'],
                    ],
//                    [
//                        'actions' => ['manage'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $sum['subtotal'] = 0;
        $sum['tax'] = 0;
        $sum['total'] = 0;

        /* items */
        $items = [];
        $lines = explode("\n", $model->details);
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

        //var_dump($items);
        //return;

        return $this->render('view', [
            'model' => $model,
            'items' => $items,
            'sum' => $sum
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     */
    public function actionCreate($id = 1)
    {
        $model = new Invoice();
        $cus = $this->loadCustomer($id);
        $model->contact = $cus['contact'];
        $model->email = $cus['email'];
        $model->ship_to = $cus['ship_to'];
        $model->sold_to = $cus['sold_to'];
        $model->details = $cus['details'];

        $model->payment_methods = $cus['payment_methods'];
        $model->payment_status = $cus['payment_status'];
        $model->shipping_carrier = $cus['shipping_carrier'];
        $model->shipping_status = $cus['shipping_status'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $shipmentFile = UploadedFile::getInstance($model, 'proof_of_shipment_file');
            if ($shipmentFile && file_exists($shipmentFile->tempName)) {
                $model->shipping_status = Invoice::SHIPPING_STATUS_SHIPPED;
                $model->proof_of_shipment = file_get_contents($shipmentFile->tempName);
            }

            $pdfFile = UploadedFile::getInstance($model, 'invoice_pdf_file');
            if ($pdfFile && file_exists($pdfFile->tempName)) {
                $model->invoice_pdf = file_get_contents($pdfFile->tempName);
            }

            /* Pictures */
            $img1 = UploadedFile::getInstance($model, 'img_1_file');
            if ($img1 && file_exists($img1->tempName)) {
                $model->img_1 = file_get_contents($img1->tempName);
            }
            $img2 = UploadedFile::getInstance($model, 'img_2_file');
            if ($img2 && file_exists($img2->tempName)) {
                $model->img_2 = file_get_contents($img2->tempName);
            }
            $img3 = UploadedFile::getInstance($model, 'img_3_file');
            if ($img3 && file_exists($img3->tempName)) {
                $model->img_3 = file_get_contents($img3->tempName);
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * send invoice via email
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEmail($id)
    {
        $model = $this->findModel($id);
        if (empty($model->invoice_pdf)) {
            Yii::$app->session->setFlash('error', SimpleinvoiceModule::t("Please upload the PDF first."));
        } else {
            $model->sendMail();
        }
        return $this->redirect(['view', 'id' => $model->id]);

    }

    /**
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * load customer
     * @param $id
     * @return mixed
     */
    protected function loadCustomer($id)
    {
        $a = [
            '1' => [
                'contact' => 'Chanmey Keo',
                'email' => 'keo.chanmey@pp-electrical.com',
                'sold_to' => 'PHNOM PENH ELECTRICAL CO.,LTD',
                'ship_to' => 'Phnom Penh, CAMBODIA',
                'payment_methods' => 'Other',
                'payment_status' => Invoice::PAYMENT_STATUS_PENDING,
                'shipping_carrier' => 'KTT',
                'shipping_status' => Invoice::SHIPPING_STATUS_PENDING,
                'details' => 'HIPS Scrap (Type 1)|33000|5000|0
HIPS Pellets (Type 2)|33000|5000|0
PVC (CFC)|33000|5000|0'
            ],
        ];
        return $a[$id];
    }
}

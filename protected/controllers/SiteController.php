<?php
use \yii\web\Controller;
use \yii\base\HttpException;

use app\models\Post;

/**
 * SiteController
 * This class provides a demonstration of a simple blog application
 */
class SiteController extends Controller
{
	/**
	 * This method returns a list of all models in the database
	 */
	public function actionIndex()
	{
		$post = new Post;
		$data = $post->find()->all();
		echo $this->render('index', array(
			'data' => $data
		));
	}

	/**
	 * This method handles the creation of new posts
	 */
	public function actionCreate()
	{
		$model = new Post;
		if (isset($_POST['Post']))
		{
			$model->title = $_POST['Post']['title'];
			$model->content = $_POST['Post']['content'];

			if ($model->save())
				Yii::$app->response->redirect(array('site/read', 'id' => $model->id));
		}

		echo $this->render('create', array(
			'model' => $model
		));
	}

	/**
	 * This method handles updating our model
	 * @param int $id    The $id we want to use
	 */
	public function actionUpdate($id=NULL)
	{
		if ($id === NULL)
			throw new HttpException(404, 'Not Found');

		$model = Post::find($id);

		if ($model === NULL)
			throw new HttpException(404, 'Document Does Not Exist');

		if (isset($_POST['Post']))
		{
			$model->title = $_POST['Post']['title'];
			$model->content = $_POST['Post']['content'];

			if ($model->save())
				Yii::$app->response->redirect(array('site/read', 'id' => $model->id));
		}

		echo $this->render('create', array(
			'model' => $model
		));
	}

	/**
	 * This action provides functionality to read data from a particular model
	 * @param  int $id    The ID of our model 
	 */
	public function actionRead($id=NULL)
	{
		if ($id === NULL)
			throw new HttpException(404, 'Not Found');

		$post = Post::find($id);

		if ($post === NULL)
			throw new HttpException(404, 'Document Does Not Exist');

		echo $this->render('read', array(
			'post' => $post
		));
	}

	/**
	 * This method provides functionality to delete a post
	 * @param  int $id delete
	 */
	public function actionDelete($id=NULL)
	{
		if ($id === NULL)
		{
			Yii::$app->session->setFlash('PostDeletedError');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		$post = Post::find($id);


		if ($post === NULL)
		{
			Yii::$app->session->setFlash('PostDeletedError');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		$post->delete();

		Yii::$app->session->setFlash('PostDeleted');
		Yii::$app->getResponse()->redirect(array('site/index'));
	}
}
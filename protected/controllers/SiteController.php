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
		$data = Post::find()->all();
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
		if ($this->populate($_POST, $model) && $model->save())
			Yii::$app->response->redirect(array('site/read', 'id' => $model->id));

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
		{
			Yii::$app->session->setFlash('error', 'A post with that id does not exist');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		$model = Post::find($id);

		if ($model === NULL)
		{
			Yii::$app->session->setFlash('error', 'A post with that id does not exist');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		if ($this->populate($_POST, $model) && $model->save())
			Yii::$app->response->redirect(array('site/read', 'id' => $model->id));

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
		{
			Yii::$app->session->setFlash('error', 'A post with that id does not exist');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		$post = Post::find($id);

		if ($post === NULL)
		{
			Yii::$app->session->setFlash('error', 'A post with that id does not exist');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

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
			Yii::$app->session->setFlash('error', 'A post with that id does not exist');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		$post = Post::find($id);


		if ($post === NULL)
		{
			Yii::$app->session->setFlash('error', 'A post with that id does not exist');
			Yii::$app->getResponse()->redirect(array('site/index'));
		}

		$post->delete();

		Yii::$app->session->setFlash('success', 'Your post has been successfully deleted');
		Yii::$app->getResponse()->redirect(array('site/index'));
	}
}
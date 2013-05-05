# Getting Started With Yii Framework 2. A Basic Tutorial

### Disclaimer
This guide is meant to help you started with Yii2. Yii2 is by no means "production" ready. I do not recommend using this in production.

------------

<<<<<<< HEAD
### Edit
This guide has been updated to reflect some changes that should import the quality of this post. Namely:

1) Getting ActiveRecord to autoincriment the database
2) Changing the charset of utf8.
3) Removal of model() method in Post Model
4) Update findallMethod
5) Added Flash Messages instead of 404 errors.
6) Removal of XSS Injection Vector <-- FML

------------

=======
>>>>>>> d4e408152e8292e555fca0359f250e19b110bc1f
Today Yii Framework made the announcement that Yii2 was now available for a public preview. A lot has changed from Yii1 to Yii2, 

This tutorial will go over making a simple blog site in Yii2. For this guide, we'll be getting and installing Yii2, creating a base app, connecting to a database, and configuring logic to create, updated, read, and delete posts.

For this tutorial, here's what you'll need:

* A webserver, either Apache or Nginx. For this guide I'll be using Nginx. The conversion to Apache should be trivial however, so don't worry if you don't have an Nginx server lying around.
* A database to connect our app to. I'll be using MySQL 5.5
* Basic PHP knowledge. I'll try to keep it as simple as possible, but the more PHP you know, the easier it will be to follow along.
* Basic Knowledge of either Yii or MVC. If you don't have any experience with MVC, I recommend you [read up on MVC fundamentals](http://www.yiiframework.com/doc/guide/1.1/en/basics.mvc). You _can_ follow this guide without them, however things will make more sense if you have a concept of what MVC is.

So, lets get started!

For this tutorial I'm going to assume that you already have your webserver setup. For this guide, I'm going to be using the following directories and urls:

* /var/www/yii2 for my DocumentRoot
* yii2.erianna.com for my hosting url

Additionally, by the end of this tutorial you will be able to view a demo of the app we've made at [yii2.erianna.com](yii2.erianna.com).


### Downloading Yii2

Download a copy of Yii2 from Github either by cloning the repository or by downloading a tar archive. 

    git clone git@github.com:yiisoft/yii2.git /dir/to/yii2

or

    wget https://github.com/yiisoft/yii2/archive/master.zip
    unzip master.zip /dir/to/yii2

Once you've extracted Yii2, navigate to __/dir/to/yii2/framework__

    cd /dir/to/yii2/framework

And run the following commands to setup your first webapp, providing yes to the first prompt.

    php yiic.php app/create /var/www/yii2
    yes

This is the equivalent of creating a new webapp in Yii 1.x. Now navigate to /var/www/yii2. Inside this folder you'll see one file and one folder.

~~~
$ ls -l
total 8
-rwxrwxrwx 1 user www-data  265 May  4 09:30 index.php
drwxrwsr-x 5 user www-data 4096 May  4 09:07 protected
~~~

Before we can get our site up and running, we'll need to make some modifications to our index.php file. In my opinion, there are some questionable design choices. Hopefully these will be fixed before Yii2's final release to make it more user friendly to get setup.

Change your index.php to look like this.

~~~
<?php
define('YII_DEBUG', true);

// Change this to your actual Yii path
require '/path/to/yii2/framework/yii.php';

// Change __DIR__ to __FILE__ so we can load our config file
$config = require dirname(__FILE__).'/protected/config/main.php';
$config['basePath'] = dirname(__FILE__).'/protected';

$app = new \yii\web\Application($config);
$app->run();
~~~

Lets break down the changes we made:

~~~
// Change this to your actual Yii path
require '/path/to/yii2/framework/yii.php';
~~~

First, we need to change our "require" path to point to to where our framework/yii.php is actually located at. By default, this makes the assuming it is in the current directory, It's possible it might be, but it needs to know exactly where Yii2 is located at.

~~~
$config = require dirname(__FILE__).'/protected/config/main.php';
$config['basePath'] = dirname(__FILE__).'/protected';
~~~

Next, we updated our config path to use <strong>__FILE__</strong> instead of <strong>__DIR__</strong>. We're making this change so our webapp can actually load.

--------------------

Before we continue, it's important to notice there's something new in Yii" __Name spaces__

~~~
$app = new \yii\web\Application($config);
~~~

The point of name spaces is to encapsulate code in logical units to prevent collision of multiple code bases. So you have two classes, both named __Foo__ and that both have the method __Bar__, assuming they are both name spaces you can call both of them independently of each other as follows, without any collision of classes.

~~~
$foo = new \namespace\Foo;
$foo2 = new \namespace2\Foo;
~~~

Name spaces are an easy way to prevent collision of code. I'd recommend you'd [read up on them](http://www.php.net/manual/en/language.namespaces.rationale.php), since Yii2 has been name spaced.

---------------

And like that, you've just created your fist web app! Navigate to where yii2 is located at, and you should see the following page.

<center>
<img src="https://www.erianna.com/uploads/c4ca4238a0b923820dcc509a6f75849b.png"  style="max-width: 700px"/>
<span style="font-weight:bold; font-size: 12px;">Your First Yii2 App!</span>
<br />
<br />
<br />
</center>

Unlike Yii 1.x's skeleton app, the base skeleton app for Yii2 isn't that exciting yet. Lets make it do a little more.

First, open up your __/protected/views/layout/main.php__ file, then replace it with the following code:

~~~
<?php use yii\helpers\Html as Html; ?>
<!doctype html>
<html lang="<?php \Yii::$app->language?>">
	<head>
		<meta charset="utf-8" />
		<title><?php echo Html::encode(\Yii::$app->name); ?></title>
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	</head>
	<body>
  		<div class="container">
  			<div class="navbar navbar-inverse">
  				<div class="container">
	 				<div class="navbar-inner">
	    				<a class="brand" href="/"><?php echo Html::encode(\Yii::$app->name); ?></a>
					</div>
				</div>
			</div>
    		<div class="content">
				<?php echo $content?>
			</div>
  		</div>
	</body>
</html>
~~~

Then refresh the page. See? Isn't everything prettier with Twitter Bootstrap? Again, not much has changed from Yii1 to Yii2. You still have $content being the variable you use for displaying content in views. __Yii::app()__ has changed to be __Yii::$app__ however. Again, everything in Yii2 has been name spaced, so it's important to remember to access everything by their new name space instead of just calling the raw class.

Now lets do some real coding!

### Connecting To Your Database

For this app, we'll just have a simple __Posts__ table containing our blog posts.

#### Creating the Database Table
Login to MySQL, and create a user and database both named yii2. Then run the following command to update the db structure for yii2.

~~~
DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

INSERT INTO `yii2`.`posts` (`id`, `title`, `content`, `created`, `updated`) VALUES ('1', 'Example Title', 'New Post', NOW(), NOW());
~~~

#### Updating Your Config
Then, navigate to __/var/www/yii2/protected/__ and open up __config.php__ in your favorite editor and replace it with the following.

~~~
<?php
return array(
'id' => 'webapp',
'name' => 'My Web Application',

'components' => array(
        // uncomment the following to use a MySQL database
        'db' => array(
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhostt;dbname=yii2',
                'username' => 'yii2', 
                'password' => '<password>',
                ),
                'cache' => array(
                        'class' => 'yii\caching\DummyCache',
                ),
        ),
);
~~~

If you're familiar with Yii2, this is a _massive_ improvement over the hideous config files that were generated in Yii1. While the same structure is there, this is the only thing that is needed to get your database up and running.

#### Creating a Post Model

Create a new folder called __models__ under protected, and then created a new file call __Post.php__ in __models__ and add the following code to it.

~~~
<?php
namespace app\models;
class Post extends \yii\db\ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'posts';
	}

	/**
	 * @return array primary key of the table
	 **/	 
	public static function primaryKey()
	{
		return array('id');
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'created' => 'Created',
			'updated' => 'Updated',
		);
	}
}
~~~

If you're familiar with Yii1, the only thing that has really changed in ActiveRecord (at least in this example) is that the functions __primaryKey__, and __tableName__ are now static methods. Everything else is basically the same. For the most part, ActiveRecord has remained unchanged.

The most important part of this class is the inclusion of the name space __app\models__. This tells Yii where we can reference this file at.

Unlike Yii1, where you can just call the class name, Yii2 uses a different type of auto loaded which requires you to explicitly define what classes you intent on using. While this might make development a little slower (Trying to remember to include \yii\framework\web\Html can get old really fast instead of just calling CHtml), it should make Yii2 significantly faster. Since the autoloader won't have to search through the entire framework just to get one class. At least in theory.

### CRUD!

Now that we've name spaced our Post model, we can get to working creating our basic CRUD app.

#### Viewing Everything
First, lets start by updating our index action so that we can view everything. I like to be able to view everything from my index action, so lets start there. Open up __controllers/SiteController.php__ and update your index action so it looks as follows:

~~~
public function actionIndex()
{
	$data = Post::find()->all();
	echo $this->render('index', array(
		'data' => $data
	));
}
~~~

A couple of things to notice here. First, __::model()->__ is gone. Raw model data from ActiveRecord and Model can now be accessed directly by calling the method you want information on. So $post->find()->all(). While I am personally pretty fond of Post::model()->findAll(), the new way of accessing data pretty standard and is easier to read. 

Secondly, findAll has been replaced by find()->all(). All find methods now stem either from find() or findBySql().

Finally, $this->render() now requires an echo in front of it. Personally, I hate this. It feels _very_ CakePHP ish, and is in my opinion redundant. The idea behind this however is that stuff you want to be rendered to the screen should be echoed, otherwise it is simply available as a $variable for you to manipulate. Personally, I prefer the older way of rendering to a variable (passing a function parameter to the render method), but maybe it will grow on me.

Now refresh the page...

If you're familiar with namespaces, your probably screaming at me right now asking me why I didn't include the Post model. If you're not familiar with name spaces, you're probably confuses as to why your getting an error. The reason is simple. _You have to remember your name spaces in Yii2__. Anything you want to use, you have to explicitly define unless it already has been defined.

Add the following line to top of _SiteController_. Then refresh the page.

~~~
use app\models\Post;
~~~

Now lets add some markup to display our posts. Open up __protected/views/site/index.php__ and replace the content with the following:

~~~
<?php use yii\helpers\Html; ?>

<?php echo Html::a('Create New Post', array('site/create'), array('class' => 'btn btn-primary pull-right')); ?>
<div class="clearfix"></div>
<hr />
<table class="table table-striped table-hover">
	<tr>
		<td>#</td>
		<td>Title</td>
		<td>Created</td>
		<td>Updated</td>
		<td>Options</td>
	</tr>
	<?php foreach ($data as $post): ?>
		<tr>
			<td>
				<?php echo Html::a($post->id, array('site/read', 'id'=>$post->id)); ?>
			</td>
			<td><?php echo Html::a($post->title, array('site/read', 'id'=>$post->id)); ?></td>
			<td><?php echo $post->created; ?></td>
			<td><?php echo $post->updated; ?></td>
			<td>
				<?php echo Html::a(NULL, array('site/update', 'id'=>$post->id), array('class'=>'icon icon-edit')); ?>
				<?php echo Html::a(NULL, array('site/delete', 'id'=>$post->id), array('class'=>'icon icon-trash')); ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
~~~

Hmmm, looks different doesn't it! CHtml::link() is gone, and has been replaced by a helper name space called Html. Fortunately, the structure from CHtml::link to Html::a hasn't changed at all. So it's simply a matter of filling in the parameters.

#### Read

Reading is easy, so lets take care of that next. Create a new method in SiteController with the following definition:

~~~
public function actionRead($id=NULL)
{
	echo 'HelloWorld';
}
~~~

Now, if you navigate to ?r=site/read&id=1. You should see __HelloWorld__ being printed to the screen. See it? Good. That means our method is being triggered. Now lets configure it so that we can get some data from our database.

First, lets add HttpException to our SiteController so that we can throw HttpExceptions if a post isn't found.

~~~
use \yii\base\HttpException;
~~~

Then, lets create our read action

~~~
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
~~~

Just for clarity, HttpException is essentially CHttpException. All we're doing is making querying the database for a post if an id of $id, and rendering it. If the post isn't found, or an id isn't provided then we're throwing an HttpException.

Next, we need to create a new file __protected/views/site/read.php__, and add the following code to it to display our post.

~~~
<?php use yii\helpers\Html; ?>
<div class="pull-right btn-group">
	<?php echo Html::a('Update', array('site/update', 'id' => $post->id), array('class' => 'btn btn-primary')); ?>
	<?php echo Html::a('Delete', array('site/delete', 'id' => $post->id), array('class' => 'btn btn-danger')); ?>
</div>

<h1><?php echo $post->title; ?></h1>
<p><?php echo $post->content; ?></p>
<hr />
<time>Created On: <?php echo $post->created; ?></time><br />
<time>Updated On: <?php echo $post->updated; ?></time>
~~~

Now, on our index page, click on "Example Post". Tada! You can now view posts for your blog!

#### Delete

Deleting posts is also very simple, so we'll do that next. Create a new method with the following definition:

~~~
public function actionDelete($id=NULL)
{

}
~~~

For this method, we're going to be a little more complex. We're going to redirect the user back to the homepage after we've successfully deleted their post. Lets get started.

First, lets define our method

~~~
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
~~~

A couple things to note with Yii2. First, redirecting is now done through __Yii::$app->getResponse->redirect()__ instead of __$this->redirect()__. While this makes sense from code organization perspective, it's a pain to type out. Additionally, it also gives the feeling that $app is severely overloaded. While a pain to type, it's maintained the same method definition from Yii1.

Secondly, setFlash is now accessed through $app instead of app(). You should be getting the hange of that by now though. =)

Now that we've handled deleting, lets go back to our __protected/views/site/index.php__ file and catch those flash message we sent.

Just add the following below the first <hr /> tag

~~~
<?php if(Yii::$app->session->hasFlash('error')): ?>
<div class="alert alert-error">
	<?php echo Yii::$app->session->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
<div class="alert alert-success">
	<?php echo Yii::$app->session->getFlash('success'); ?>
</div>
<?php endif; ?>
~~~

Now try deleting "Example Post". Pretty neat huh? You're getting the idea of Yii::$app now, right?

#### Create

Now lets get to the fun stuff, creating new entries in our blog. We're going to need a couple of things to post creation. First, we're going to be use ActiveForm to handle the form itself. Secondly we're going to catch catching and validating $_POST data. And finally we're going to be saving it to the database for storage. Lets get started.

First, we'll need to create a view for our form. Start by creating a file __protected/views/site/create.php__. Since we'll be using a widget in our view, you'll also need to create a folder "assets" in the root of our web app and make it writable by your web server. Chmod 755 usually does the trick. Then add the following function definition to SiteController.

~~~
public function actionCreate()
{
	$model = new Post;
	if ($this->populate($_POST, $model) && $model->save())
			Yii::$app->response->redirect(array('site/read', 'id' => $model->id));

	echo $this->render('create', array(
		'model' => $model
	));
}
~~~

<<<<<<< HEAD
=======
That looks more or less the same as a Yii1 Form. A couple of differences though. first, Controller now has a method called "populate" ($this->populate($ds, $model)) which in theory should allow us to bypass this whole isset($_POST) nonsense. The code for creating new data would look like this.

~~~
if ($this->populate($_POST, $model))
{
	//Then do something
}
~~~

Unfortunately I couldn't get it to work in the latest version. My model data remained unchanged. Secondly, I was unable to get $model->attributes = $_POST['Post'] to work. ActiveRecord still seems to be lagging behind, so for now, manually setting data is the way to go.

Finally, I hit another road block getting data to actually save into the database with a unique PK. So we're going to have to do that manually. If someone _does_ figure out what's wrong, be sure to leave a comment below.

First, lets update our PostModel so we can get a unique primary key working. Simply add a the following method to the end of your Post model:

~~~
public function beforeSave($insert)
{
	if ($this->isNewRecord)
	{
		$command = static::getDb()->createCommand("select max(id) as id from posts")->queryAll();
		$this->id = $command[0]['id'] + 1;
	}

	return parent::beforeSave($insert);
}
~~~
>>>>>>> d4e408152e8292e555fca0359f250e19b110bc1f

All that this does, is check if the model we're inserting is a new record, and if it is, to get the highest id in the database and add one to it, and use that for our id. Notice the new method "populate".

I trid a bunch of different combinations (NULL, 0, _ for $model->id, but for some reason ActiveRecord refused to save the model with anything but 0. I have no idea why it isn't working yet).

Now that that has been settled out, add the view for our create file.

~~~
<?php use yii\helpers\Html; ?>

<?php $form = $this->beginWidget('yii\widgets\ActiveForm', array(
	'options' => array('class' => 'form-horizontal'),
)); ?>
	<?php echo $form->field($model, 'title')->textInput(array('class' => 'span8')); ?>
	<?php echo $form->field($model, 'content')->textArea(array('class' => 'span8')); ?>
	<div class="form-actions">
		<?php echo Html::submitButton('Submit', null, null, array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
~~~

And there you go, you've now saved your model. But things are a little weird wouldn't you agree? For instance, why are our created and updated times all 0's? What happens if we input a blank form?

Lets fix those two issues before continuing. First, we need to open up our Post model, and add the following method:

~~~
public function rules()
{
	return array(
		array('title, content', 'required'),
	);
}
~~~

This method makes the title and content field required. Now when you attempt to save the model, you'll get an error if either of those fields are blank. And since we're using bootstrap, it's pretty easy to see _what_ the error was. Give it a try!

Next, we're going to auto populate our created and updated times.

First, we're going to add another __use__ line to the top of our model.

~~~
use \yii\db\Expression;
~~~

Second, we're going to update our beforeSave method to add these automatically for us.

Inside our if ($this->isNewRecord) block, add the following line.

~~~
$this->created = new Expression('NOW()');
~~~

Then, before return parent::beforeSave($insert) add:

~~~
$this->updated = new Expression('NOW()');
~~~

Your final method definition should look like this:

~~~
public function beforeSave($insert)
{
	if ($this->isNewRecord)
		$this->created = new Expression('NOW()');
	return parent::beforeSave($insert);
}
~~~

Now try saving again. Our model now has validation on both the title, and content fields, and will automatically update the created and update time for you. Now lets do updating.

#### Update

Our update action is going to be nearly identical to our create action. The only difference between the two is how we determine what model we're going to use.

In our create action, we used.

~~~
$model = new Post;
~~~

In our update action, we're going to use.

~~~
$model = Post::find($id);
~~~

I like HTTPExceptions for stuff when it isn't found. That being said, you should probably be nice to the user and just warn them with a soft flash message instead of a hard http exception that makes it look like your site exploded.

~~~
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
~~~

Notice anything interesting? We're still using the create view in our update action because _they are exactly the same_. Cool huh?

### Sanatizing Data Input
So you have everything setup now. Easy huh? But what happens if you throw the following into your title.

~~~
<script type="text/javascript">alert("Hello!");</script>
~~~

If you're like me, you probably assumed ActiveRecord would sanatize that for you. I know I certainly did. Bad news folks, it doesn't. _Escape and sanatize your stuff. There are evil people about there who want to ruin you because you forgot to sanatize your user input._

So, anywhere that you're outputting user inputted data, escape it using __Html::encode()__. To provide an example, our __protected/views/site/read.php__ should now have output that looks as follows:

~~~
<h1><?php echo Html::encode($post->title); ?></h1>
<p><?php echo Html::encode($post->content); ?></p>
~~~

Now when you visit that page, and some evil person has added a script tag in your form all that is seen is sanatized input.

### Concluding Thoughts

Well there you have it. In a couple of hours you've gone from knowing nothing about Yii Framework 2 to having a very simple CRUD application. Using this knowledge you can easily scale your application to support having users, having authentication for the views, adding additional tables to your database, and even adding more powerful features.

Yii2 is _very_ similar to Yii 1.x, however there are still a lot of differences that you'll need to reload. While Yii2 isn't very well documented yet, I wrote this entire blog post just by looking at the source code on Github. The code for Yii2 is pretty well documented, and since the methods are similar to Yii 1.x, it was easy to find what I was looking for, either through examples or just the source code for various classes.

As we discovered, there are still some issues that need to be resolved (either through better documentation of ActiveRecord or through fixing something that may be broken).

If you'd like the browse the source code for this project, [you can download it from Github.](https://github.com/charlesportwoodii/yii2-blog-demo).

If you'd like to play around with the demo itself without installing it, you can browse the app at [yii2.erianna.com](http://yii2.erianna.com).

The original blog post for this entry can be found on my personal blog here: [Getting Started With Yii Framework 2](https://www.erianna.com/getting-starting-with-yii-framework-2).

For more tutorials, guides, source code, and information visit my blog at [https://www.erianna.com](https://www.erianna.com)

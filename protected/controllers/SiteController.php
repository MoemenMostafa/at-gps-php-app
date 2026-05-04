<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name=$model->name;
				$subject=$model->subject;
				$email = $model->email;
				$body = $model->body;



				Yii::import('application.extensions.phpmailer.JPhpMailer');
				$mail = new JPhpMailer;
				$mail->IsSMTP();
				$mail->Host = 'smtp.gmail.com:465';
				$mail->SMTPSecure = "ssl";
				$mail->SMTPAuth = true;
				$mail->Username = Yii::app()->params['adminEmail'];
				$mail->Password = Yii::app()->params['adminEmailPassword'];
				$mail->SetFrom(Yii::app()->params['adminEmail'], 'At-GPS');
				$mail->Subject = "At-GPS Contact-us";
				$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
				$mail->MsgHTML("<h1>$subject</h1><h3>Name: $name</h3><h3>Email: $email</h3><br/><div style='white-space: pre;'>$body</div>");
				$mail->AddAddress(Yii::app()->params['adminEmail'], 'At-GPS');
				$mail->Send();
				//mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		
		if (!Yii::app()->user->isGuest){
				$this->redirect(array('/map'));
		}else{

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
                        
                        if ( $request = Yii::app()->getRequest() && $request->isAjaxRequest)
                        {
                           // ensure we're rendering this in a parent window, not an update div
                           $this->renderPartial('loginRedirect', array(), false, true);
                           Yii::app()->end();
                        }
	
			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					if (Yii::app()->user->company_id == 16) {
						Yii::app()->user->logout();
						// echo "<script>alert('Account Suspeneded. Please contact the financial department.');</script>";
						echo "<script>window.location.replace('/suspended.php');</script>";
					} else {
						$this->redirect(array('/map'));
					}
			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	
}
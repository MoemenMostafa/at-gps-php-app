<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	public $form=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $userData; // Holds an activeRecord with current user. NULL if guest
	public $adminLevel;
	
	
	public function init() {
	
        // Redirect user to the login page (temp. solution)
            if (strpos($_SERVER['REQUEST_URI'],"/index.php?r=site/login") === false ){

                if (Yii::app()->user->isGuest){
                    $this->redirect(array("site/login"));
                }
            }
            
        // Load the user
            if (!Yii::app()->user->isGuest){
                $this->userData = User::model()->findByPk(Yii::app()->user->id);
                $this->adminLevel = UserType::model()->findByPk($this->userData->user_type_id);
                date_default_timezone_set(Yii::app()->user->timezone);
                
            }
            //echo $_SERVER['REQUEST_URI'];
	}
        
	
	public function allowUser($min_level) { //0 no login required 1..1000: admin level
    	$current_level = 0;
		if ($this->userData !== null){
			$current_level = $this->adminLevel->level;}else{$this->redirect(array("site/login"));}
		if ($min_level > $current_level) {
			throw new CHttpException(403, 'You have no permission to view this content');
		}

	}
}
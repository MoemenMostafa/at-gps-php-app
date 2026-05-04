<?php

class LevelLookUp{
      //const MEMBER = 0;
      const ADMIN  = 1000;
      // For CGridView, CListView Purposes
      public static function getLabel( $level ){
          if($level == self::MEMBER)
             return 'Member';
          if($level == self::ADMIN)
             return 'Administrator';
          return false;
      }
      // for dropdown lists purposes
      public static function getLevelList(){
          return array(
                 self::MEMBER=>'Member',
                 self::ADMIN=>'Administrator');
    }
}


class EWebUser extends CWebUser{
 
    protected $_model;
 
    function isAdmin(){
        $user = $this->loadUser();
        if ($user)
           return $user->userType->level==LevelLookUp::ADMIN;
        return false;
    }

 
    // Load user model.
    protected function loadUser()
    {
        if ( $this->_model === null ) {
                $this->_model = User::model()->findByPk( $this->id );
        }
        return $this->_model;
    }
}
?>

#!/bin/bash

#-------------------------------------------------------------------------------
$USERNAME = $1;
$USERNAME = $2;
#-------------------------------------------------------------------------------
printf '<?php
class DatabaseConnection
{
  static function connect()
  {
    return new DB\SQL(
  	\"mysql:host=localhost;port=3306;dbname=%s_SimpleModel\",
  	\"%s_%s\",
  	\"%s\"
    );
  }
}
?>' $USERNAME get_current_user() $USERNAME $PASSWORD > ~/AboveWebRoot/autoload/DatabaseConnection.php
#-------------------------------------------------------------------------------
# Clone DWD Git
git clone https://github.com/Edinburgh-College-of-Art/FFF-SimpleExample.git ~/public_html/FFF-SimpleExample

#!/bin/bash
#-------------------------------------------------------------------------------
# test bash if
INPUTMATCH=0
while [[ $INPUTMATCH -eq 0 ]]; do
  read -p 'CPANEL Username: ' USERNAME
  read -p 'Confirm: ' CONFIRMUSERNAME

  if [[ "$USERNAME" == "$CONFIRMUSERNAME" ]]; then
    INPUTMATCH=1
  else
    printf 'Usernames did not match\n'
  fi
done

INPUTMATCH=0
while [[ $INPUTMATCH -eq 0 ]]; do
  read -sp 'CPANEL Password: ' PASSWORD
  printf '\n'
  read -sp 'Confirm Password: ' CONFIRMPASSWORD

  if [[ "$PASSWORD" == "$CONFIRMPASSWORD" ]]; then
    INPUTMATCH=1
  else
    printf 'Passwords did not match\n'
  fi
done
printf '\n'
#-------------------------------------------------------------------------------
# add F3
mkdir ~/AboveWebRoot
git clone https://github.com/bcosca/fatfree.git ~/AboveWebRoot/fatfree-master

# Add DB file
mkdir ~/AboveWebRoot/autoload

printf 'class DatabaseConnection
{
  static function connect()
  {
    return new DB\SQL(
  	\"mysql:host=localhost;port=3306;dbname=%s_dwd\",
  	\"%s\",
  	\"%s\"
    );
  }
}
' $USERNAME $USERNAME $PASSWORD > ~/AboveWebRoot/autoload/DatabaseConnection.php
#-------------------------------------------------------------------------------

# Clone DWD Git
cd ~/public_html/
# git clone --recurse-submodules -j8 https://github.com/Edinburgh-College-of-Art/dynamic-web-design.git dwd
# cd dynamic-web-design
git clone https://github.com/Edinburgh-College-of-Art/FFF-SimpleExample.git example
cd example
git config receive.denyCurrentBranch updateInstead

# Create project git
mkdir ~/public_html/my-site
cd ~/public_html/my-site
git init
git config receive.denyCurrentBranch updateInstead

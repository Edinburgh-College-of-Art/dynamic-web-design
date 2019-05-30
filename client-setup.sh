#!/bin/bash
#-------------------------------------------------------------------------------
read -p "is this the right directory?\n $PWD \n [y/n]: " A
if [[ "$A" == "n" ]]; then
exit 1
fi
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
  read -p 'Your Domain (e.g. www.name.co.uk): ' YOURDOMAIN
  printf '\n'
  read -p 'Confirm: ' CONFIRMDOMAIN

  if [[ "$YOURDOMAIN" == "$CONFIRMDOMAIN" ]]; then
    INPUTMATCH=1
  else
    printf 'Domains did not match\n'
  fi
done
printf '\n'
#-------------------------------------------------------------------------------
git clone 'ssh://'"$USERNAME"'@'"$YOURDOMAIN"'/~/public_html/dynamic-web-design'
git clone 'ssh://'"$USERNAME"'@'"$YOURDOMAIN"'/~/public_html/my-site'
cd my-site
touch README.md
git add .
git commit -m "init"
git push
#-------------------------------------------------------------------------------

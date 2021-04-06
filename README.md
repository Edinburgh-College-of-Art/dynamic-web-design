# Dynamic Web Design

Course material for Dynamic Web Design

<!-- TOC depthFrom:1 depthTo:6 withLinks:1 updateOnSave:1 orderedList:0 -->

- [DynamicWebDesignExamples](#dynamicwebdesignexamples)
	- [Setup](#setup)
		- [1. Domain of Ones Own Setup](#1-domain-of-ones-own-setup)
		- [2. Database Setup](#2-database-setup)
		- [3. Fat Free Framework Setup](#3-fat-free-framework-setup)
		- [4. Project Setup](#4-project-setup)
		- [5. PhpStorm Setup](#5-phpstorm-setup)
		- [6. GitHub Setup](#6-github-setup)
		- [Setup Script](#setup-script)
	- [Git Hook Setup](#git-hook-setup)
	- [Staging](#staging)
	- [Notes](#notes)

<!-- /TOC -->

## Lecture Notes


## Setup

### 1. edinburgh.domains Setup

[Follow the steps here]() to register your domain.

### 2. Database Setup

1. In cpanel, go to `MySQL® Databases`
   2. create a new database named `dwd`
      - Note: database will be in the form `CPANEL-USERNAME_dwd`
   3. add user to database
   4. give user all privileges
2. In `AboveWebRoot` create folder titled `autoload`
   1. in `autoload` add a file `DatabaseConnection.php`
   2. in `DatabaseConnection.php` add the following text
   3. fill in your details in placeholders.

### 3. Fat Free Framework Setup

1. [Download Fat Free Framework](https://github.com/bcosca/fatfree/archive/master.zip)
2. Put Fat Free on your server
   1. go to cpanel
   2. file manager
   3. add new folder named `AboveWebRoot`
   4. upload `fatfree-master` to that folder

```php
class DatabaseConnection
{
  static function connect()
  {
    return new DB\SQL(
  	'mysql:host=localhost;port=3306;dbname=CPANEL-USERNAME_dwd',
  	'CPANEL-USERNAME',
  	'CPANEL-PASSWORD'
    );
  }
}
```

5. in cpanel: goto `phpMyAdmin`
   1. create a table named `simpleModel` for the `FFF-SimpleExample`
   2. create a table for storing your data

### 4. Project Setup

1. git clone in cpanel
   1. clone to `public_html/dwd/`
2. git clone in local machine
3. create git in `public_html/my-site`
4. git clone in local machine

### 5. PhpStorm Setup

1. Go to JetBrains and fill in the [Student Licence Form](https://www.jetbrains.com/shop/eform/students)
2. Download PHPStorm
3. Open project folder
4. Add your name to README.md
   1. commit
      - macOS: <kbd>⌘</kbd> + <kbd>K</kbd>
      - Windows: <kbd>CTRL</kbd> + <kbd>K</kbd>
   2. add commit message
   3. Commit and Push:
      - macOS: <kbd>⌘</kbd> + <kbd>⌥</kbd> + <kbd>K</kbd>
      - Windows: <kbd>CTRL</kbd> + <kbd>⇧</kbd> + <kbd>K</kbd>
   4. Push:
      - macOS: <kbd>⌥</kbd> + <kbd>P</kbd>
      - Windows: <kbd>ALT</kbd> + <kbd>P</kbd>

### 6. GitHub Setup

1. Sign-in to GitHub
2. create repository
3. open terminal
   - Windows Users will need [Git for Windows](https://gitforwindows.org)
4. `cd path/to/project
`
5. on GitHub copy clone url
6. `git remote set-url --add --push origin CLONE_URL`
7. `git push CLONE_URL --force`

### Setup Script

First setup your database, then copy and paste these commands into the terminal of the server and your own machine respectively.

**Server Side**

```bash
wget https://raw.githubusercontent.com/Edinburgh-College-of-Art/dynamic-web-design/master/server-setup.sh; chmod +x server-setup.sh ; ./server-setup.sh
```

**local side**

```bash
bash <(curl -s https://raw.githubusercontent.com/Edinburgh-College-of-Art/dynamic-web-design/master/client-setup.sh)
```

***
<!--
## Git Hook Setup

**Web Server**
```bash
ssh username@your-domain
mkdir ~/public_html/website/path
mkdir ~/project_repo/
cd ~/project_repo/
git init
```

**Local**
```bash
mkdir -p ~/Documents/dwd/my-site
cd ~/Documents/dwd/my-site
git init
git remote add origin ssh://username@your-domain/~/project_repo/
```

**Web Server**

For post-receive hook, sync all files in repo to website

```bash
ssh username@your-domain
cd ~/project_repo/
echo \
"#!/bin/sh
rsync ../* ~/public_html/website/path
" >> .git/hooks/post-receive
chmod +x .git/hooks/post-receive
```

## Staging

**Add more remotes for staging! You can push all over the place, just repeat the steps on different servers and you’re a git-deployment maniac.**

```bash
git remote add stage ssh://projects@domain.com/~/stage.example.com
git push stage master
```


## Notes -->

<style>
  kbd {
    display: inline-block;
    margin: 0 .1em;
    padding: .1em .6em;
    font-family: Arial,"Helvetica Neue",Helvetica,sans-serif;
    font-size: 11px;
    line-height: 1.4;
    color: #242729;
    text-shadow: 0 1px 0 #FFF;
    background-color: #e1e3e5;
    border: 1px solid #adb3b9;
    border-radius: 3px;
    box-shadow: 0 1px 0 rgba(12,13,14,0.2),0 0 0 2px #FFF inset;
    white-space: nowrap;
    font-style: normal;
  }
</style>

# DynamicWebDesignExamples

A collection of examples using PHP, JavaScript and the F3 framework for Dynamic Web Design

## Setup

### 1. Domain of Ones Own Setup

### 2. Fat Free Framework Setup

1. [Download Fat Free Framework](https://github.com/bcosca/fatfree/archive/master.zip)
2. Put Fat Free on your server
   1. go to cpanel
   2. file manager
   3. add new folder named `AboveWebRoot`
   4. upload `fatfree-master` to that folder

### 3. Database Setup

1. In cpanel, go to `MySQL® Databases`
   2. create a new database named `dwd`
      - Note: database will be in the form `CPANEL-USERNAME_dwd`
   3. add user to database
   4. give user all privileges
2. In `AboveWebRoot` create folder titled `autoload`
   1. in `autoload` add a file `DatabaseConnection.php`
   2. in `DatabaseConnection.php` add the following text
   3. fill in your details in placeholders.

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

5. in cpanel: goto phpMyAdmin
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
   - Windows Users will need [Git for Windows]
4. cd path/to/project
5. on GitHub copy clone url
6. `git remote set-url --add --push origin CLONE_URL`
7. `git push CLONE_URL --force`

### Setup Script

**Server Side**

```bash
# add F3
mkdir ~/AboveWebRoot

# Clone DWD Git
cd ~/public_html/
git clone --recurse-submodules -j8 https://github.com/Edinburgh-College-of-Art/dynamic-web-design.git
cd dynamic-web-design
git config receive.denyCurrentBranch updateInstead

# Create project git
mkdir ~/public_html/my-site
cd ~/public_html/my-site
git init
git config receive.denyCurrentBranch updateInstead
```

**local side**

```bash
cd project/directory
git clone ssh://matthe31@matthew-hamilton.co.uk/~/public_html/dynamic-web-design
git clone ssh://matthe31@matthew-hamilton.co.uk/~/public_html/my-site
cd my-site
touch README.md
git add .
git commit -m "init"
git push
```

## Notes

These examples assume you are using the playground server at ECA or you are aware of how to port over.

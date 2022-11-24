<!DOCTYPE html>
<html>
<body>

  <h2>Setup Server For FatFreeFramework</h2>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    <label for="uname">Database username: <?= get_current_user().'_'?></label>
    <input type="text" id="uname" name="uname" value="dbusername"><br>
    <label for="confirm_uname">Confirm Database username: <?= get_current_user().'_'?></label>
    <input type="text" id="confirm_uname" name="confirm_uname" value="dbusername"><br>
    <label for="dbpass">Database Password</label>
    <input type="text" id="dbpass" name="dbpass" value="e.g. VFhCy#U}0DXL"><br>
    <label for="confirm_dbpass">Confirm Database Password</label>
    <input type="text" id="confirm_dbpass" name="confirm_dbpass" value="e.g. VFhCy#U}0DXL"><br>
    <input type="submit" value="Submit">
  </form>


  <?php
  $username = get_current_user();
  $home = '/home/'.$username;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $dbusername = $_POST['uname'];
    $confirm_name = $_POST['confirm_uname'];
    $pass = $_POST['dbpass'];
    $confirm_pass = $_POST['confirm_dbpass'];

    // does name start with user name
    $is_data_correct = true;
    // does username match
    if ($dbusername != $confirm_name)
    {
      echo "<pre>Usernames do not match\n</pre>";
      echo "<pre>".$dbusername."\n</pre>";
      echo "<pre>".$confirm_name."\n</pre>";
      echo "<pre>\n</pre>";
      $is_data_correct = false;
    }
    // does password match
    if ($pass != $confirm_pass)
    {
      echo "<pre>Passwords do not match</pre>";
      echo '<pre>'.$pass."\n"."</pre>";
      echo '<pre>'.$confirm_pass."\n"."</pre>";
      echo '<pre>'."\n"."</pre>";
      $is_data_correct = false;
    }

    $db_user = $username.'_'.$dbusername;



    try{
      new \PDO("mysql:host=localhost;port=3306;dbname=".$username."_SimpleModel",$db_user,$pass);
    }catch (Exception $ex){
      echo "Error Code: ".$ex->getCode()."\n";
      echo "\n";
      switch ($ex->getCode()) {
        case 1044:

          $dbh = new \PDO("mysql:host=localhost;port=3306;",$db_user,$pass);
          $dbs = $dbh->query( 'SHOW DATABASES' );

          echo "<h3>Databases</h3>".'<br>';
          $database_has_correct_name = false;
          $db = $dbs->fetchColumn( 0 );
          $num_databases = 0;
          while( ( $db = $dbs->fetchColumn( 0 ) ) !== false )
          {
            $num_databases++;
            if($db == $username."_SimpleModel")
            {
              $database_has_correct_name = true;
            }
            echo $db.'<br>';
          }
        if($database_has_correct_name)
        {
          echo "<pre>Username and Password are correct, {$db_user} probably does not have access to the database\n</pre>";
        }
        elseif ($num_databases === 0) {
          echo "<pre>{$db_user} does not have access to a database\n</pre>";
        }
        else {
          echo "<pre>No database found with correct name {$username}_SimpleModel</pre>";
        }
        break;
        case 1045:
        echo "<pre>Username Does not exist</pre>";
        break;
        default:
        echo "<pre>Username or Password is incorrect or your Database is not named: ".$username.'_SimpleModel</pre>';
      }

      $is_data_correct = false;

      echo "<pre>\n</pre>";
    }

    if($is_data_correct)
    {
      echo "<pre>Success!\n</pre>";

      $file_txt = "<?php\n";
      $file_txt .="class DatabaseConnection\n";
      $file_txt .="{\n";
      $file_txt .="  static function connect()\n";
      $file_txt .="  {\n";
      $file_txt .="    return new DB\SQL(\n";
      $file_txt .="  	\"mysql:host=localhost;port=3306;dbname={$username}_SimpleModel\",\n";
      $file_txt .="  	\"{$username}_{$dbusername}\",\n";
      $file_txt .="  	\"${pass}\"\n";
      $file_txt .="    );\n";
      $file_txt .="  }\n";
      $file_txt .="}\n";
      $file_txt .="?>\n";
      $dbConnectionPHP = fopen($home."/AboveWebRoot/autoload/DatabaseConnection.php", "w") or die("Unable to open file!");
      fwrite($dbConnectionPHP, $file_txt);
      fclose($dbConnectionPHP);

      $f3 = require($home.'/AboveWebRoot/fatfree-master/lib/base.php');
      $f3->set('AUTOLOAD','autoload/;'.$home.'/AboveWebRoot/autoload/');
      $db = DatabaseConnection::connect();
      $db->exec("CREATE TABLE IF NOT EXISTS simpleModel (id int NOT NULL AUTO_INCREMENT, name varchar(128),  colour varchar(128), PRIMARY KEY (id))");

      echo "<script>window.location.replace(\"/FFF-SimpleExample\");</script>";
    }
  }
  else {
    # Download and set file structure for Fat Free
    if (!file_exists($home."/AboveWebRoot"))
    {
      shell_exec("mkdir ~/AboveWebRoot");
    }
    if (!file_exists($home."/AboveWebRoot/fatfree-master")){
      shell_exec("git clone --depth 1 --branch 3.7.3 https://github.com/bcosca/fatfree.git ~/AboveWebRoot/fatfree-master");
    }
    if (!file_exists($home."/AboveWebRoot/autoload")){
      shell_exec("mkdir ~/AboveWebRoot/autoload");
    }
    if (!file_exists($home."/public_html/FFF-SimpleExample")){
      shell_exec("wget https://github.com/Edinburgh-College-of-Art/dynamic-web-design/releases/download/0.1.0/FFF-SimpleExample.zip");
      shell_exec("unzip FFF-SimpleExample.zip");
      shell_exec("rm FFF-SimpleExample.zip");
    }
  }
  ?>

</body>
</html>

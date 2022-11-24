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

  <pre>
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
        echo "Usernames do not match\n";
        echo $dbusername."\n";
        echo $confirm_name."\n";
        echo "\n";
        $is_data_correct = false;
      }
      // does password match
      if ($pass != $confirm_pass)
      {
        echo "Passwords do not match";
        echo $pass."\n";
        echo $confirm_pass."\n";
        echo "\n";
        $is_data_correct = false;
      }

      $db_user = $username.'_'.$dbusername;

      try{
        new \PDO("mysql:host=localhost;port=3306;dbname=".$username."_SimpleModel",$db_user,$pass);
      }catch (Exception $ex){
        echo $ex->getCode();
        echo "\n";
        switch ($ex->getCode()) {
          case 1044:
          echo "Username and Password are correct, but this user does not access to the database";
          break;
          case 1045:
          echo "Username Does not exist";
          break;
          default:
          echo "Username or Password is incorrect or your Database is not named: ".$username.'_SimpleModel';
        }

        $is_data_correct = false;

        echo "\n";
      }

      if($is_data_correct)
      {
        echo "Success!\n";

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
        echo "Table Created\n";
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
  </pre>
</body>
</html>

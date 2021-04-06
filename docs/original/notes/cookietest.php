<?php
// This example shows how to set/delete a cookie
//<!--- if the URL variable delcookie exists, set cookie expiration date to NOW --->
if (isset($_GET["delcookie"])) {
	setcookie ("LastName", "", time() - 3600);
   echo "Cookie deleted ...<p>";
  echo '<a href="cookietest.php">Try again ...</a>';
}
else if (isset($_POST["submit"])) {
//<!--- if the form has been submitted, set cookie to the name on the form --->
    setcookie("LastName", $_POST["name"], time()+3600);  /* expire in 1 hour */
	echo "Thank you " . $_POST["name"] ."<p>";
	echo '<a href="cookietest.php">Try again ...</a>';
}
else if (isset($_COOKIE["LastName"])) {
//<!--- if the cookie is set, print its value --->
	echo "Hello again " .  $_COOKIE["LastName"]."<p>";
	echo '<a href="cookietest.php?delcookie=yes">(Click here if you are not ' . $_COOKIE["LastName"] . ' or to delete record of your name ...)</a>';
}
else {
//<!--- if none of the above, offer the form to enter a name --->
?>
	Please enter your name here:<br>
	<form action="cookietest.php" method="post">
	<input name="name" type="text"><br>
	<input name="submit" type="submit" value="Enter">
	</form>
<?php
}
?>
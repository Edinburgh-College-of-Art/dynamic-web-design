---
layout: page
title: Further PHP
author: "John Lee"
---


- [An example application: the ImageServer](#an-example-application-the-imageserver)
    - [1. The Manpics class](#1-the-manpics-class)
    - [2. Uploading the images](#2-uploading-the-images)
        - [2.1 Sanitising input](#21-sanitising-input)
        - [2.2 Uploading](#22-uploading)
    - [2.3 Storing the image data](#23-storing-the-image-data)
    - [3. Viewing the images](#3-viewing-the-images)
        - [3.1 Retrieving image information](#31-retrieving-image-information)
        - [3.2 Displaying an image](#32-displaying-an-image)
    - [4. Deleting an image](#4-deleting-an-image)
    - [5. Final thoughts](#5-final-thoughts)

## An example application: the ImageServer

The strategy in this example is to build an application that will allow
us to upload images (or in principle any kind of file), see the images
we have uploaded, and delete them if desired. We will also want to be
able to show the images as standardised thumbnails as well as at
whatever size they were uploaded. To do all this, we will use a simple
database to maintain information about the images. The application is
complicated by the fact that for security reasons we need to store the
uploaded images "above the web root", where they cannot be directly
accessed by potentially malicious code; but all the same we will need
some way of having a URL for each image, so that we can show them on web
pages.

As always, there are many different ways this could be done, and many
different possible architectures even for such a small application. In
the chosen approach, the code is written using object-oriented syntax to
organise things into classes. In this case, it's arguably unnecessary,
in that we are not going to create objects as instances of the classes,
but here it's partly being used as a means of keeping the code tidy.

The complete code can be downloaded from the main notes page, and it's
best to look at the snippets discussed below in their context in the
whole application. Note that the application also requires a database
with a table, here called "picdata", that contains the fields _id,
picname, picfile_ and _pictype_, which are used respectively to store an
auto-incremented id, an arbitrary name or label entered by the user, the
file name and the MIME type of each uploaded image. If you have any
questions about any of it, do just [email me](mailto:j.lee@ed.ac.uk).

### 1. The Manpics class

We define the class Manpics in the included file _manpics.php_. This is
a class containing properties (variables) and methods (functions)
relating to managing the pictures. Here are the properties:

[static $imagestore="../../upload";
static $picdb="dwd11_jlee";
static $pictable="picdata";
static $thumbsize = 100;
static $connect;
static $connectionInitialised=false;]{.style2}

Here _\$imagestore_ is where we will store the image files on the
server. It should be above the web root but also be somewhere where you
have access to write files, which in the setup you have on playground
means at the same level as your html directory. _\$picdb_ is just the
database in which details will be kept, _\$pictable_ is the table in the
DB, and thumbsize is the size in pixels for thumbnail images.
_\$connect_ is the DB connection, and there's a flag we will set to
tell us whether we are connected already.

Manpics defines a number of methods. We won't discuss _connectDB()_
here, except to note that it sets _\$connectionInitialised_, and then if
that's true when it's called it does nothing, so it can be called at
any time. Other methods include:

uploadPic() -- which deals with uploading imagefiles
storePic() -- which stores data about an image
createThumbnail() -- which creates a thumbnail-size copy of an image
picInfoService() -- a "service" that returns information about the
images that are stored
deletePicService() --  a service that deletes specified images,
including their files and database data.

We'll discuss these as we see how they're used.

### 2. Uploading the images

The first thing the user wants to do is upload an image. So we offer a
simple form, _upload.php_
(<http://playground.eca.ed.ac.uk/~jlee/imageserver1.1/upload.php>):

<form action="upload.php" method="post"
enctype="multipart/form-data">
<label for="file">Select a file:</label>
<input type="file" name="file" id="file" />
<br />
<label for="picname">Picture title:</label>
<input type="text" name="picname" id="picname" />
<br />
<input type="submit" name="submit" value="Submit" />
</form>

The form is normal HTML, using an input of type _file_, which will
invite the user to choose a file that will be uploaded and a text input
that will be used simply to name or describe the file. You'll see that
the action of this form is the template itself, so the content of it
continues with a PHP script. The first thing it does is include another
file called _manpics.php_, which we'll look at shortly, then checks
that the submit button is clicked.

<?php
// We have to include this: "require" will cause a fatal error if it
doesn't exist
require("manpics.php");

if (isset($_POST["submit"])) {
echo "<h3>Thanks for your upload ...</h3>n";

// This is calling the function uploadPic that belongs to the class
Manpics, as defined in manpics.php
// Input is now sanitised to prevent XSS attacks and the like ...
$picname = filter_input(INPUT_POST, 'picname',
FILTER_SANITIZE_SPECIAL_CHARS);
Manpics::uploadPic($_FILES["file"],$picname);
echo "<hr /><p><a href='viewimages.php'>View images
...</a></p>n";
}
?>

### 2.1 Sanitising input

The _filter_input()_ function is ensuring that the variable value
acquired from the form meets certain criteria. In this case, it's
checking whether the variable called _picname_ in the POST input
(flagged as _INPUT_POST_) is **_sanitised_** (which just means
"cleaned up") by filtering out any "special characters" (i.e.
_FILTER_SANITIZE_SPECIAL_CHARS_). We need to do this to avoid
potential security threats, especially cross-site scripting (XSS)
attacks. You should in fact ALWAYS use _filter_input()_ when using form
data, especially if you are storing the results into a database --
there are a good many filters you can choose from other than just
special characters -- see
<http://uk1.php.net/manual/en/function.filter-input.php> and
<http://uk1.php.net/manual/en/filter.filters.php>.

We then call the _Manpics::uploadPic()_ function, which is a function
defined as part of the Manpics class in the included file _manpics.php_.
We give it \$\_FILES["file] (which is data that identifies the file
selected by the user as a result of our using the form input of type
_file_) and the now sanitised _picname_ parameter that has come from the
form text input.

### 2.2 Uploading

In _manpics.php_ there is a class containing properties (variables) and
methods (functions) relating to managing the pictures. This class is
called Manpics. It includes as a method the function _uploadPic()_,
which we are invoking from _upload.php_. The syntax
_Manpics::uploadPic()_ just means call the method _uploadPic()_ from the
class Manpics (notice the distinction between this and calling the
method in an instance of an object of that class -- here we have not
created a Manpics object).

Warning: the code for this function looks complicated! I have
colour-coded it to help identify parts of it in the following
discussion.

public function uploadPic($picfile, $picname) {
[if ((($picfile["type"] == "image/gif")
|| ($picfile["type"] == "image/png")
|| ($picfile["type"] == "image/jpeg")
|| ($picfile["type"] == "image/pjpeg"))
&& ($picfile["size"] < 200000)) {
if ($picfile["error"] > 0) {
echo "Return Code: " . $picfile["error"] . "<br />";
}]{.redCode}
[else {
echo "Upload: " . $picfile["name"] . "<br />";
echo "Type: " . $picfile["type"] . "<br />";
echo "Size: " . ($picfile["size"] / 1024) . " Kb<br />";
echo "Temp file: " . \$picfile["tmp_name"] . "<br
/>";]{.blueCode}

[if (file_exists(self::$imagestore . "/" . $picfile["name"]))
{
$newpicfile =
basename($picfile["tmp_name"]).$picfile["name"];
}
else {
$newpicfile = \$picfile["name"];
}

$newpicfile = strtolower($newpicfile); // map to lower case, avoiding
problems later with recognising uppercase file extensions!
$dest = self::$imagestore . "/" . $newpicfile;]{.greenCode}
[move_uploaded_file($picfile["tmp_name"], $dest);
echo "Stored in: " . $dest . "<br />n";]{.purpleCode}
[self::storePic($newpicfile,$picname,$picfile["type"]);
self::createThumbnail($dest, self::$imagestore . "/"
.self::thumbFile($newpicfile), basename($picfile["type"]));
echo "Thumbnail: " . self::thumbFile($newpicfile) . "<br
/>n";]{.yellowCode}
}
}
else {
echo "Invalid file";
}
}

[The first condition is just checking that the type of the file we are
uploading (_\$picfile["type"]_) is one of a small set that we want
to accept ]{.redCode}(it's important for security reasons not to let
the user upload just anything)[, is not above a certain size, and has
not already created an error]{.redCode}. [If this is all OK, we print
out some details for the user ]{.blueCode}[and then generate the
pathname we want the file to have when it is stored. This is based on
the name of the original image and the variable *self::$imagestore*,
which is the directory (folder) in which the images will be
kept.]{.greenCode} Note at this point that the file is in fact _already
uploaded_ (if _\$picfile["error"]_ was 0) so [all we have to do is
move it from its temporary location, which is given as
_\$picfile["tmp_name"]_, to the place we want to keep it, which is
the filename we have just generated. The moving is done using
_move_uploaded_file()_]{.purpleCode}.

[We then use *self::storePic()* to use the *storePic()* method of
*Manpics* (which is referred to here as *self* because we are defining a
method inside it) to generate database data for this image, and
*self::createThumbnail()* to create and store a thumbnail version of the
image]{.yellowCode}.

### 2.3 Storing the image data

The method _storePic()_ very simply copies details of the uploaded image
into a DB record:

private function storePic($filename,$picname,$pictype) {
self::connectDB();
$q = "INSERT INTO ".self::$pictable."(picname,picfile,pictype)
VALUES(?,?,?)";
if ($stmt = self::$connect->prepare($q)) {
$stmt->bind_param("sss", $picname,$filename,$pictype);
$stmt->execute();
$stmt->close();
}
}

-- where _\$filename_ is the actual pathname of the file as saved,
_\$picname_ is the name given to the picture as typed in by the user,
and _\$pictype_ is the MIME type of the image file (e.g. jpg). Entering
the image into the DB creates an _id_ for it, which will be completely
crucial.

### 3. Viewing the images

To view all the images we will want a template for a page on which they
will all appear (as thumbnails) -- this is _viewimages.php_
(<http://playground.eca.ed.ac.uk/~jlee/imageserver1.1/viewimages.php>).

### 3.1 Retrieving image information

In here, we first query _Manpics::picInfoService()_ to find out what
images there are. It just returns all the data in the DB, unless it is
given a non-zero ID, in which case it returns just the data for that
picture:

[public function picInfoService($picID=0) { // This means the parameter
$picID is 0 by default, i.e. if it's not given any other value when
the function is called
self::connectDB();
if ($picID == 0) {
if ($result = self::$connect->query("SELECT id, picname, picfile,
pictype FROM ". self::$pictable)) {
// We are now constructing an array to return, containing the result
rows as associative arrays
[$ret = array(); // create an empty array
while ($data = $result->fetch_assoc()) {
$ret[] = $data;
}
return $ret;]{.redCode}
}
}
else {
if ($stmt = self::$connect->prepare("SELECT id, picname, picfile,
pictype FROM ". self::$pictable . " WHERE id=?")) {
$stmt->bind_param("i", $picID);
$stmt->execute();
$stmt->bind_result($id,$picname,$picfile,$pictype);
$stmt->fetch(); // There should be only one result: no loop here
$arr = array("id"=>$id, "picname"=>$picname,
"picfile"=>$picfile, "pictype"=>$pictype);
$ret[] = $arr;
return $ret; // An array just like the one in the other condition, but
with only one row in it.
}
}
}]{.style2}

The code in red is assembling an array of all the results, because
_\$result->fetch_assoc()_ provides each row from the database in the
form of an associative array, and these are collected together into a
larger array, which is then what is returned to the calling point (in
this case, in _viewimages.php_). In _viewimages.php_ there is code to
support paging of the images and so forth, but the central part of it is

foreach ($picStuff as $row) {
printf("[<a
href="?delete=yes&picID=%d">Delete</a>]{.redCode}n",
$row["id"]);
printf("[<a href="imagelocator.php?picID=%d"
target="_blank"><img
src="imagelocator.php?thumb=yes&picID=%s" /></a>]{.blueCode}
%s<br/>n", $row["id"], $row["id"],
$row["picname"]);
}
}

in which _\$picstuff_ is the array that came back from
_picInfoService()_ and so we are creating a series of links associated
with each row of data there.[ The first link is a delete link, which
simply goes back to *viewimages.php* with a query string that says
*"?delete=yes&picID="* followed by the ID of the current
image]{.redCode}. (Note that there is nothing before the query in this
URL, which means that it will simply link back to the same file that
this code appears in, which is _viewimages.php_.) Clicking on this link
will invoke the code at the top of the viewimages script, where one
sees:

if (isset($_GET["picID"]) && isset($\_GET["delete"]))
Manpics::deletePicService(\$\_GET["picID"]);
}

which engages the _Manpics::deletePicService()_ method to delete the
image and its DB record. [The second link feeds the ID of the current
image to *imagelocator.php*, which is a key element in this
application]{.blueCode}.

### 3.2 Displaying an image

This is the part that would normally seem simple: we just use the image
URL. _But the images don't have a URL because they're stored above the
web root!_ The solution to this is to provide a URL that actually points
to a PHP script that can behave exactly like an image. A script will
seem (to the browser) to be an image if it outputs a suitable image
header followed by raw image data (because this is just what the browser
sees if it looks at an image file). The template _imagelocator.php_ is
just this kind of script: we can use it as the source parameter in an
image link, e.g.:

[<img src="imagelocator.php?thumb=yes&picID=3" />]{.style2}

where it will seem to the browser to just be an image, in this case the
thumbnail-sized version of the image with ID 3 in the database (assuming
this exists, but of course we should never have an ID here for an image
that doesn't exist).

This is achieved in the script by using _picInfoService()_ again to find
out the file path to the image file, then constructing an image header
based on the MIME type of the file. (in the code, this is done by
working back from the filename extension, but in principle it might make
more sense just to get the MIME type from the DB.) Then the header is
output from the function _ImageLocator::SendImageHeader()_. It's
crucial that nothing else is output before this, i.e. there can be no
HTML or other output of any kind from the script in this template,
except for this header and then the raw image file data, which is
extracted from the image file by using the built-in PHP function
_readfile()_.

In _viewimages.php_ we have therefore now generated a display of a neat
set of clickable thumbnail images, each one being a link to the
full-size version of the image, and each with a "delete" link that
will allow the image, and all trace of it, to be deleted, as follows.

### 4. Deleting an image

To delete an image, we need to remove the image file, the thumbnail
image file, and the related database record. This is done in
_Manpics::deletePicService()_:

public function deletePicService($picID) {
self::connectDB();
[if ($stmt = self::$connect->prepare("SELECT picfile FROM ".
self::$pictable . " WHERE id=?")) {
$stmt->bind_param("i", $picID);
$stmt->execute();
$stmt->bind_result($picfile);
$stmt->fetch(); // There should be only one result: no loop
here]{.redCode}
[unlink(self::$imagestore . "/" . $picfile);
unlink(self::$imagestore . "/" .
self::thumbFile($picfile));]{.blueCode}
$stmt->close();
}
[if ($stmt = self::$connect->prepare("DELETE FROM ".
self::$pictable . " WHERE id=?")) {
$stmt->bind_param("i", $picID);
$stmt->execute();]{.greenCode}
$stmt->close();
}
return "Deleted";
}

[The DB is queried to get the data]{.redCode}, then [the builtin
function *unlink()* is used to remove the image file and the
thumbnail]{.blueCode}, then [the database record is
deleted]{.greenCode}.

### 5. Final thoughts

Note that things other than images can be handled easily by changing or
removing the restriction on file types allowed in _uploadPic()_. --
Movies, 3D models, anything you like. You might want to have a more
elaborate way of keeping track of these, though.

There are many aspects and elements in even this small application that
haven't been mentioned here: do study the code, and raise questions
about anything that's unclear (of which there will be plenty!). If
using or adapting this code, you should certainly introduce error
checking. As mentioned before, many things could have been done
differently, and probably much better: this was was translated quickly
from a ColdFusion version that was put together very quickly in the
first place, and is far from perfect. You could consider many
improvements -- e.g. should the thumbnails be created on upload or only
when information is requested? Should the material in _imagelocator.php_
mostly be made into just another function in _manpics.php_? Etc.

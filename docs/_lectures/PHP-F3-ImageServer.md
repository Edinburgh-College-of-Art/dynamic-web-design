---
layout: page
title: Further PHP, with Fat-Free Framework (F3)
author: "John Lee"
order: 76
week: 5
---

-   [An example application: the ImageServer](#an-example-application-the-imageserver)
    -   [1. The ImageServer class](#1-the-imageserver-class)
    -   [2. Uploading the images](#2-uploading-the-images)
        -   [2.1 Uploading](#21-uploading)
        -   [2.2 Storing the image data](#22-storing-the-image-data)
    -   [3. Viewing the images](#3-viewing-the-images)
        -   [3.1 Retrieving image information](#31-retrieving-image-information)
        -   [3.2 Displaying an image](#32-displaying-an-image)
    -   [4. Deleting an image](#4-deleting-an-image)
    -   [5. Final thoughts](#5-final-thoughts)

## An example application: the ImageServer

The strategy in this example is to build an application that will allow us to upload images (or in principle any kind of file), see the images we have uploaded, and delete them if desired. We will also want to be able to show the images as standardised thumbnails as well as at whatever size they were uploaded. To do all this, we will use a simple database to maintain information about the images (which is a form of non-standard metadata, additional to the standard kind of metadata often stored in [EXIF](https://en.wikipedia.org/wiki/Exif) format in the image file itself). The application is complicated by the fact that for security reasons we need to store the uploaded images "above the web root", where they cannot be directly accessed by potentially malicious code; but all the same we will need some way of having a URL for each image, so that we can show them on web pages.

As always, there are many different ways this could be done, and many different possible architectures even for such a small application. In the chosen approach, the code is written using the Fat-Free Framework (F3). This allows us to define a quite nice separation between code that drives the presentation of the images, and code that drives the manipulation of the database etc. The concept is a loose application of the Model-View-Controller (MVC) pattern, but not very strict because no particular adherence to this pattern is enforced by F3.

The complete code can be downloaded from the main notes page, and it's best to look at the snippets discussed below in their context in the whole application, which also includes other useful comments in the code. Note that the application also requires a database with a table, here called "picdata_fff", that contains the fields _id, filepath, title_ and _type_, and _thumbnail_ which are used respectively to store an auto-incremented id, the file name, an arbitrary title or label entered by the user, the MIME type of each uploaded image, and the filename of the thumbnail image that our code will create. If you have any questions about any of it, do just [email me](mailto:j.lee@ed.ac.uk).

### 1. The ImageServer class

We define the class ImageServer in the file _ImageServer.php_, which is in the "autoload" folder within an F3 application setup called FFF-ImageServer, which has a structure directly analogous to the FFF-SimpleExample application. The ImageServer class is a class containing properties (variables) and methods (functions) relating to managing the pictures. Here are the properties:

```php
private $filedata;
private $uploadResult = "Upload failed! (unknown reason)";
private $table = "picdata_fff";
private $thumbsize = 200; // max width/height of thumbnail
images
private $acceptedTypes = ["image/jpeg", "image/png", "image/gif", "image/tiff", "image/svg+xml"]; // file types we'll accept for uploading
```

_\$table_ is the table in the DB, and thumbsize is the size in pixels for thumbnail images. _\$filedata_ is simply a variable to hold data temporarily, and _\$uploadResult_ is a self-explanatory message, which will be changed by the code below as necessary. These are all _private_ properties, which cannot be accessed other than by methods defined inside the class itself.

In the index.php file for the application, we also define several (global) F3 variables, as usual:
```php
$f3->set('AUTOLOAD','autoload/;../../../AboveWebRoot/autoload/');        // autoload ImageServer class and DB stuff
$db = DatabaseConnection::connect();                                        // defined as autoloaded class in AboveWebRoot/autoload/
$f3->set('DB', $db);
$f3->set('DEBUG',3);
$f3->set('UI','ui/');
$f3->set('UPLOADS','../../../AboveWebRoot/ServerImages/');
```

Here, _UPLOADS_ is the folder where we will store the image files on the server. It should be above the web root but also be somewhere where you have access to write files, which in the setup you have on playground means at the same level as your html directory. As in the FFF-SimpleExample case, we have here assumed a folder at that level called _AboveWebRoot_ and we have created our _ServerImages_ folder inside it. _DB_ is just the database in which details will be kept.

ImageServer has an empty constructor function, because no initial setting of the varables is required beyond what we have already done. Otherwise, it defines a number of methods. These include:

- `upload()` -- which deals with uploading imagefiles
- `store()` -- which stores data about an image
- `getImageData()`, `getAllImageData()` -- services that return information about the images that are stored
- `deleteService()` -- a "service" that deletes specified images, including their files and database data
- `showImage()` -- a method that outputs the raw content of an image file, with a suitable type header, as explained below
- `thumbFile()` -- which returns the name of the thumbnail file for a given image
- `createThumbnail()` -- which creates a file containing a thumbnail-size copy of an image (always jpg, no matter what the type of the original image).

We'll discuss these as we see how they're used. The last two of them are _private_ methods, which means they can only be used by code of other methods inside the class itself.

### 2. Uploading the images

The first thing the user wants to do is upload an image. So we offer a simple form in an F3 template, _upload.html_. This is defined in the folder identified by the _UI_ variable, as in the FFF-SimpleExample. The template is reached immediately by the route defined for the application root (<http://jlee.edinburgh.domains/fatfree/FFF-ImageServer/>):

```php
<h1>Upload</h1>
<form name="upload" method="POST" action="{{ @BASE }}{{@PARAMS.0 }}" enctype="multipart/form-data">
  <label for='picfile'>Select image file: </label><input type="file" name="picfile" id="picfile" /><br />
  <label for='picname'>Picture title: </label><input type="text" name="picname" id="picanme" placeholder="Title for image" size="80" /><br />
  <input type="submit" name="submit" value="Submit" />
</form>
```

The form is normal HTML, using an input of type _file_, which will invite the user to choose a file that will be uploaded and a text input that will be used simply to name or describe the file. Note the attribute enctype="multipart/form-data"  --- this is important. You'll see that the action URL of this form is the F3 route [{{ @BASE }}{{ @PARAMS.0 }}], which means the base URL with the first element of the form PARAMS, which is the file name "upload", but visited with a POST request method. In _index.php_, the route for a POST request to "/upload" says:


```php
$f3->route('POST /upload',
    function($f3) {
        $is = new ImageServer;
        if ($filedata = $is->upload()) { // if this is null, upload failed
            $f3->set('filedata', $filedata);

            $f3->set('html_title','Image Server Home');
            $f3->set('content','uploaded.html');
            echo template::instance()->render('layout.html');
        }
    }
);
```

-- which creates an ImageServer object, and runs its _upload()_ method, which returns the data from the upload, or _null_ if the upload failed. If the upload succeeded, these various data are shown to the user via the _uploaded.html_ template.

#### 2.1 Uploading

The _upload()_ method is made much simpler by using F3, which provides a class called _Web_ for operations like this. The main part of the code is just this:

```php
$overwrite = false; // set to true, to overwrite an existing file; Default: false
$slug = true;       // rename file to filesystem-friendly version

Web::instance()->receive(function($file,$anything)
{
  $this->filedata = $file;
  if($this->filedata['size'] > (2 * 1024 * 1024)) // if bigger than 2 MB
  {
    $this->uploadResult = "Upload failed! (File > 2MB)";
    return false; // this file is not valid, return false will skip moving it
  }
  if(!in_array($this->filedata['type'], $this->acceptedTypes)) // if not an approved type
  {
    $this->uploadResult = "Upload failed! (File type not accepted)";
    return false; // this file is not valid, return false will skip moving it
  }
  $this->uploadResult = "success"; // everything worked OK
  return true; // allows the file to be moved from php tmp dir to your defined upload dir
}, $overwrite, $slug);

```

This looks more complicated than it is ... 

The first two lines just set two variables that we will use later to supply arguments to the upload function: this helps us to remember what the arguments mean. We create a variable, *$files*, which will be the uploaded file data as returned by a method that belongs to the *Web* class (see <https://fatfreeframework.com/3.8/web>). We make an instance of this class, and call its *receive()* method. The first argument of the method is an anonymous function, which takes two arguments, *$file* and *$anything* (for our purposes the value of the latter will not be used and it doesn't matter what it's called). *$file* will become the data about the uploaded file, so we save it by putting it into the variable *$this->filedata*, which means it will be available to any method of the ImageServer class. We then have a couple of tests, to check whether the uploaded file is less than 2MB (an arbitrary limit, which we could change if we like) and that it is one of a specified set of types (because we don't want to allow uploads of just anything). If these tests fail, the anonymous function returns `false`, and this will cause the upload to be aborted, but we set an informative error message which can be used later. Otherwise, we set a variable to say that everything has worked and return `true`, which means that the uploaded file will be moved into the uploads folder specified in the F3 variable UPLOADS. The final two arguments of the Web *receive()* method are given using the variables we set earlier: *$overwrite* is `true` if we want the upload to overwrite any existing file with the same name. (Since it's `false` here, an attempt to upload the same image twice will fail, which may seem undesirable. However, this is better than having one image file associated with two sets of image metadata, which wil cause problems if we want to delete one of them.) *$slug* is true if we want the file name to be "slugged", which means that unusual characters etc. will be transformed to avoid any problems with the filesystem.

#### 2.2 Storing the image data

The method _store()_ very simply copies details of the uploaded image into a DB record, using the F3 database mapper object:

```php
public function store() {
  global $f3; // because we need f3->get()
  $mapper = new DB\SQL\Mapper($f3->get('DB'),$this->table); // create DB query mapper object
  $mapper->title = $this->filedata["title"];
  $mapper->filepath = $this->filedata["name"];
  $mapper->type = $this->filedata["type"];
  $mapper->thumbnail = $filedata['thumbnail'];
  $mapper->save();
}
```

-- where _filepath_ is the actual pathname of the file as saved, _title_ is the name given to the picture as typed in by the user, and _type_ is the MIME type of the image file (e.g. jpg). Entering the image into the DB creates an _id_ for it (by auto-increment), which will be completely crucial later.

### 3. Viewing the images

To view all the images we will want a template for a page on which they will all appear (as thumbnails) -- this is called _viewimages.html_ (viewed via the route <http://jlee.edinburgh.domains/fatfree/FFF-ImageServer/viewimages>).

#### 3.1 Retrieving image information

In here, we first query the _ImageServer_ method _getAllImageData()_ to find out what images there are. It just returns all the data in the DB; a similar method, _getImageData()_, takes an image ID and returns just the data for that picture:

```php
  // given an image ID as argument it returns data only about that image.
    public function getImageData($id)
    {
        global $f3;
        $mapper = new DB\SQL\Mapper($f3->get('DB'), $this->table);    // create DB query mapper object
        $mapper->load(['id=?',$id]);
        $imageData = [
            'filepath'   => $f3->get('UPLOADS') . $mapper['filepath'],  // add UPLOADS file path
            'type'       => $mapper['type'],
            'title'      => $mapper['title'],
            'id'         => $mapper['id'],
            'thumbnail'  => $f3->get('UPLOADS') . $mapper['thumbnail']  // ditto
        ];
        return $imageData;
    }

    //-------------------------------------------------------------------------------------------
    // return data on all images
    public function getAllImageData()
    {
        global $f3;
        $mapper    = new DB\SQL\Mapper($f3->get('DB'), $this->table);    // create DB query mapper object
        $imageData = [];
        $images    = $mapper->find();

        foreach ($images as $image) {
            array_push($imageData, [
                'filepath'   => $f3->get('UPLOADS') . $image['filepath'],
                'type'       => $image['type'],
                'title'      => $image['title'],
                'id'         => $image['id'],
                'thumbnail'  => $f3->get('UPLOADS') . $image['thumbnail']
            ]);
        }
        return $imageData;
    }
```

The code here is assembling an array of all the results, because _\$mapper->find()_ provides each row from the database in the form of an associative array, and the relevant elements are extracted from this and then collected together into a larger array, which is then what is returned to the calling point (in this case, in _index.php_). In _index.php_ there is code for the _viewimages_ route URL that very simply acquires the above data from the _getAllImageData()_ method and then feeds it to the _viewimages.html_ template:

```php
$f3->route('GET /viewimages',
function($f3) {
  $is = new ImageServer;
  $info = $is->getAllImageData();
  $f3->set('datalist', $info);
  $f3->set('content', 'viewimages.html');
  echo template::instance()->render('layout.html');
});
```

#### 3.2 Displaying an image

The _viewimages.html_ template contains a central loop that displays the images:

```php
<repeat group="{{ @datalist }}" value="{{ @item }}">
    <div id="imgdisplay">
        <p><a href="{{ @BASE }}/image/{{ @item.id }}"><img src="{{
@BASE }}/thumb/{{ @item.id }}" /></a></p>
        <p>{{ @item.title }} (<a href="{{ @BASE }}/delete/{{
@item.picID }}">Delete?</a>)</p>
    </div>
</repeat>
```

and what happens here is that it goes through the IDs of all the images that are in the DB, displaying each one through a URL of the form: _BASE_/thumb/_id_, as a link that when clicked will go to a URL of the form: _BASE_/image/_id_. For example, the URL <http://jlee.edinburgh.domains/fatfree/FFF-ImageServer/thumb/1> shows the thumbnail associated with the image in the database that has id=1 (assuming the image with this id still exists, i.e. hasn't been deleted), and <http://jlee.edinburgh.domains/fatfree/FFF-ImageServer/image/1> shows the image itself at its original size. It also includes a link to delete the image. The URL <http://jlee.edinburgh.domains/fatfree/FFF-ImageServer/delete/0> would delete image 0 (however, there is never an image with ID=0, so nothing will be be deleted if this link is visited -- please do **NOT** delete image 1, otherwise the above couple of links will not work!).

This is the part that would normally seem simple: we just use the image URL. _**But the images don't have a URL because they're stored above the web root!**_ The solution to this is to provide a URL that actually points to a piece of code that can behave exactly like an image. A URL will seem (to the browser) to be an image if it outputs a suitable image header followed by raw image data (because this is just what the browser sees if it looks at an image file). The code for a route such as _/image/1_ does just this; hence we can use it as the source parameter in an image link, e.g.:

```php
<img src="http://jlee.edinburgh.domains/fatfree/FFF-ImageServer/image/1"/>
```

where it will seem to the browser to just be an image, in this case the thumbnail-sized version of the image with ID 1 in the database (assuming it exists, which it doesn't; but of course in practice we should never use an ID here for an image that doesn't exist).

This is achieved in the code for this route (in index.php, as usual) by invoking the _showImage()_ method of the _ImageServer_ class:

```php
$f3->route('GET|POST /image/@id',
function($f3) {
  $is = new ImageServer;
  $is->showImage(\$f3->get('PARAMS.id'), false);
});
```

Note here that this is defined for either GET or POST requests (because we might use POST in an AJAX request, for example), and the route is parameterised by having "@id" at the end of the URL. This means that any number entered at the end of the URL will be accepted, and will be available as _PARAMS.id_, as used in the call to _showImage()_. This is a powerful aspect of F3 that in a sense mirrors the idea of a query string. (We could alternatively have defined a URL such as _/images?id=1_, with the same effect, but then we would need to retrieve the value from _GET.id_.)

The method _showImage()_ takes the id of the image required, and a boolean parameter that will show the thumbnail if true or the original image if false.

```php
publi  public function showImage($id, $thumb)
    {
        global $f3;
        $mapper = new DB\SQL\Mapper($f3->get('DB'), $this->table); // create DB query mapper object
        $mapper->load(['id=?', $id]);                              // load DB record matching the given ID
        $fileToShow = (($thumb) ? $mapper['thumbnail'] : $mapper['filepath']);
        $fileToShow = $f3->get('UPLOADS') . $fileToShow;        // remember to add UPLOADS dir path
        $fileType   = (($thumb) ? 'image/jpeg' : $mapper['type']);    // thumb is always jpeg
        header('Content-type: ' . $fileType);               // write out the image file http header
        readfile($fileToShow);                                     // write out raw file contents (image data)
    }
```

It finds the DB record for the required image, then locates either the image or thumbnail file in the UPLOAD folder, which is in AboveWebRoot and therefore not normally visible on the web. Then it outputs an HTTP header appropriate to the MIME type of the image. This header is what tells the browser to interpret the following data as an image of that type. It then reads out the image file data directly from the image file and sends it to the output. The effect is therefore that the browser receives directly the content of a file that is stored above the web root. This is a very secure way of storing and serving files of all kinds.

_NB:_ It's crucial that nothing else is output before the HTTP header, i.e. there can be no HTML or other output of any kind from the code in index.php or the ImageServer code, except for this header and then the raw image file data. It's important to remember this e.g. if you sometimes put diagnostic "echo" commands in your code.

At the _viewimages_ URL, we have therefore now generated a display of a neat set of clickable thumbnail images, each one being a link to the full-size version of the image, and each with a "delete" link that will allow the image, and all trace of it, to be deleted, as follows.

### 4. Deleting an image

To delete an image, we need to remove the image file, the thumbnail image file, and the related database record. This is done by the _deleteService()_ method in the _ImageServer_ class:

```php
  public function deleteService($id)
    {
        global $f3;
        $mapper = new DB\SQL\Mapper($f3->get('DB'), $this->table);    // create DB query mapper object
        $mapper->load(['id=?', $id]);                            // load DB record matching the given ID
        unlink($f3->get('UPLOADS') . $mapper['filepath']);                                        // remove the image file
        unlink($f3->get('UPLOADS') . $mapper['thumbnail']);    // remove the thumbnail file
        $mapper->erase();                                                    // delete the DB record
    }
```

The DB is queried to get the data, then the builtin function *unlink()* is used to remove the image file and the thumbnail, then the database record is deleted.

### 5. Final thoughts

Note that things other than images can be handled easily by changing or removing the restriction on file types allowed in _upload()_. -- Movies, 3D models, anything you like. You might want to have a more elaborate way of keeping track of these, though.

If you look at index.php, there are various other things that haven't been mentioned in these notes, e.g. the provision of "silent" upload and delete functions that don't produce any output, and an infoService that simply outputs JSON data. These are intended to be used in AJAX requests. In effect, they provide a simple API to the image server back end.

There are many aspects and elements in even this small application that haven't been mentioned here: do study the code, and raise questions about anything that's unclear (of which there will be plenty!). If using or adapting this code, you should certainly introduce **error checking**. As mentioned before, many things could have been done differently, and probably much better: this was was translated quickly from a non-F3 version, which itself was translated quickly from an original ColdFusion version, that was put together very quickly in the first place, and is far from perfect. However, the application had to be largely restructured to make sense in F3, and it's already clear that this has been a significant improvement. You could consider many further improvements -- e.g. should the thumbnails be created on upload or only when information is requested? There is no real reason for the thumbnails always to be jpg images. Etc.
(The code here was also somewhat refactored and improved by Matthew Hamilton in about 2021-22.)

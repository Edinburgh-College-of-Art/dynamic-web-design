<?php
// index.php for Image Server app
// Create f3 object then set various global properties of it
// These are available to the routing code below, but also to the
// classes defined in autoloaded definitions
// NB nothing must be output by code in this first section, or it will break the /image/@id view
//==============================================================================
$home = '/home/'.get_current_user();
$f3 = require($home.'/AboveWebRoot/fatfree-master/lib/base.php');

// autoload Controller class(es) and anything hidden above web root, e.g. DB stuff
$f3->set('AUTOLOAD', 'autoload/;'.$home.'/AboveWebRoot/autoload/');
$db = DatabaseConnection::connect(); // fails unless run on server
$f3->set('DB', $db);
$f3->set('DEBUG', 3);		// set maximum debug level
$f3->set('UI', 'ui/');		// folder for View templates
$f3->set('UPLOADS', $home.'/AboveWebRoot/ServerImages/'); // set folder destination for uploads

//==============================================================================
// Image Server application routing
//==============================================================================

function pprint_var($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

//home page -- actually just shows upload page with a different title
$f3->route('GET /',
    function ($f3) {
        $f3->set('html_title', 'Upload Image');
        $f3->set('content', 'upload.html');
        echo template::instance()->render('layout.html');
    }
);

$f3->route('GET /about',
    function($f3)
    {
        $file = F3::instance()->read('README.md');
        $html = Markdown::instance()->convert($file);
        $f3->set('article_html', $html);
        $f3->set('content','article.html');
        echo template::instance()->render('layout.html');;
    }
);

// When using GET, provide a form for the user to upload an image via the file input type
$f3->route('GET /upload',
    function ($f3) {
        $f3->set('html_title', 'Image Server Upload');
        $f3->set('content', 'upload.html');
        echo template::instance()->render('layout.html');
    }
);

// When using POST (e.g. upload form is submitted), upload the image, then display
// some info about it via uploaded.html template
$f3->route('POST /upload',
    function ($f3) {
        $is = new ImageServer;
        if ($filedata = $is->upload()) {						// if this is null, upload failed
            $f3->set('filedata', $filedata);
            $f3->set('html_title', 'Image Server Home');
            $f3->set('content', 'uploaded.html');
            echo template::instance()->render('layout.html');
        }
    }
);

// If quiet is given, don't output any page content, but echo image data
// -- intended as AJAX interface, e.g. for mobile app
$f3->route('GET|POST /upload/quiet',
    function ($f3) {
        $is = new ImageServer;
        $filedata = $is->upload();
        echo json_encode($filedata);
    }
);

// It doesn't actually make sense to GET this ...
$f3->route('GET /uploaded',
    function ($f3) {
        $f3->set('html_title', 'Image Server Home');
        $f3->set('content', 'uploaded.html');
        echo template::instance()->render('layout.html');
    }
);

// infoService() just returns an array of info about the images, which here is JSON encoded
// and then echoed e.g. for use by AJAX calls (or debugging)
// If @id is missing or 0, all images, otherwise just the one nominated by @id
$f3->route('GET /infoservice',
    function ($f3) {
        $is = new ImageServer;
        $info = $is->getAllImageData();
        echo json_encode($info);
    }
);

$f3->route('GET|POST /infoservice/@id',
    function ($f3) {
        $is = new ImageServer;
        $info = $is->getImageData($f3->get('PARAMS.id'));
        echo json_encode($info);
    }
);

// display thumbnail images of the uploaded images, clickable for full size images,
// and with link to delete, via the viewimages.html template
// infoService() provides an array of data about the image, but in fact
// the template only uses the IDs
$f3->route('GET /viewimages',
    function ($f3) {
        $is = new ImageServer;
        $info = $is->getAllImageData();
        $f3->set('datalist', $info);
        $f3->set('content', 'viewimages.html');
        echo template::instance()->render('layout.html');
    }
);

// image and thumb generate a pure image for the original picture or thumbnail, respectively,
// copied directly from the file stored above the web root
// -- the 2nd parameter of showImage() specifies whether thumbnail (if true) or not
$f3->route('GET|POST /image/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->showImage($f3->get('PARAMS.id'), false);
    }
);

$f3->route('GET|POST /thumb/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->showImage($f3->get('PARAMS.id'), true);
    }
);

// For GET delete requests, we show the viewimages page again, now without the deleted image
$f3->route('GET /delete/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->deleteService($f3->get('PARAMS.id'));
        $f3->reroute('/viewimages');
    }
);

// For POST delete requests (presumably AJAX), we do not output any page content
$f3->route('POST /delete/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->deleteService($f3->get('PARAMS.id'));
    }
);

// Run the FFF engine
$f3->run();

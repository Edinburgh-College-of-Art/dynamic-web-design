<?php
//==============================================================================
// index.php for SimpleExample app //

// Create f3 object then set various global properties of it
// These are available to the routing code below, but also to any
// classes defined in autoloaded definitions

$home = '/home/'.get_current_user();

$f3 = require($home.'/AboveWebRoot/fatfree-master/lib/base.php');

// autoload Controller class(es) and anything hidden above web root, e.g. DB stuff
$f3->set('AUTOLOAD','autoload/;'.$home.'/AboveWebRoot/autoload/');

$db = DatabaseConnection::connect(); // defined as autoloaded class in AboveWebRoot/autoload/
$f3->set('DB', $db);

$f3->set('DEBUG',3);		// set maximum debug level
$f3->set('UI','ui/');		// folder for View templates
//==============================================================================
// Simple Example URL application routings

//home page (index.html) -- actually just shows form entry page with a different title
$f3->route('GET /',
    function ($f3)
    {
        $f3->set('html_title','Simple Example Home');
        $f3->set('content','simpleHome.html');
        echo template::instance()->render('layout.html');
    }
);
//==============================================================================
// When using GET, provide a form for the user to upload an image via the file input type
$f3->route('GET /simpleform',
    function($f3)
    {
        $f3->set('html_title','Simple Input Form');
        $f3->set('content','simpleform.html');
        echo template::instance()->render('layout.html');
    }
);
//==============================================================================
// When using POST (e.g.  form is submitted), invoke the controller, which will process
// any data then return info we want to display. We display
// the info here via the response.html template
$f3->route('POST /simpleform',
    function($f3)
    {
        $formdata = array();			// array to pass on the entered data in
        $formdata["name"] = $f3->get('POST.name');			// whatever was called "name" on the form
        $formdata["colour"] = $f3->get('POST.colour');		// whatever was called "colour" on the form
        $controller = new SimpleController('simpleModel');
        $controller->putIntoDatabase($formdata);

        $f3->set('formData',$formdata);		// set info in F3 variable for access in response template
        $f3->set('html_title','Simple Example Response');
        $f3->set('content','response.html');
        echo template::instance()->render('layout.html');
    }
);
//==============================================================================
$f3->route('GET /dataView',
    function($f3)
    {
        $controller = new SimpleController('simpleModel');
        $alldata = $controller->getData();

        $f3->set("dbData", $alldata);
        $f3->set('html_title','Viewing the data');
        $f3->set('content','dataView.html');
        echo template::instance()->render('layout.html');
    }
);
//==============================================================================
$f3->route('GET /editView',				// exactly the same as dataView, apart from the template used
    function($f3)
    {
        $controller = new SimpleController('simpleModel');
        $alldata = $controller->getData();

        $f3->set("dbData", $alldata);
        $f3->set('html_title','Viewing the data');
        $f3->set('content','editView.html');
        echo template::instance()->render('layout.html');
    }
);
//==============================================================================
$f3->route('POST /editView',
    function($f3)
    {
        $controller = new SimpleController('simpleModel');
        $controller->deleteFromDatabase($f3->get('POST.toDelete'));		// in this case, delete selected data record
        $f3->reroute();
    }
);

//==============================================================================

$f3->route('GET /about',
    function($f3)
    {
        $file = F3::instance()->read('README.md');
        $html = Markdown::instance()->convert($file);
        $f3->set('html_title', "FFF-SimpleExample");
        $f3->set('article_html', $html);
        $f3->set('content','article.html');
        echo template::instance()->render('layout.html');;
    }
);


//==============================================================================
function pprint_var($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

$f3->set('ONERROR', // what to do if something goes wrong.
    function($f3) {
        $f3->set('html_title',$f3['ERROR']['code']);
        $f3->set('DUMP', pprint_var($f3['ERROR']));
        $f3->set('content','error.html');
        echo template::instance()->render('layout.html');
    }
);

//==============================================================================
// Run the FFF engine //
$f3->run();

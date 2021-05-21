<?php
//==============================================================================
$home = '/home/'.get_current_user();
$f3   = require($home.'/AboveWebRoot/lib/base.php');
$f3->set('AUTOLOAD', 'autoload/;'.$home.'/AboveWebRoot/autoload/');
$db = DatabaseConnection::connect();
$f3->set('DB', $db);
$f3->set('DEBUG', 3);
$f3->set('UI', 'ui/');
$f3->set('UPLOADS', $home.'/AboveWebRoot/ServerImages/');
//==============================================================================
// Simple Example URL application routing

$f3->route('GET /',
  function ($f3) {
    $f3->set('html_title','Simple Example Home');
    $f3->set('content','simpleform.html');
    echo Template::instance()->render('layout.html');
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

$f3->route('GET /simple_ajax',
    function ($f3) {
        $f3->set('html_title','Query Any Site');
        $f3->set('content','exec_jquery.html');
        echo Template::instance()->render('layout.html');
    }
);

$f3->route('GET /random',
    function ($f3) {
        $f3->set('html_title','Get Random Image');
        $f3->set('content','random_image.html');
        echo Template::instance()->render('layout.html');
    }
);

// When using GET, provide a form for the user to upload an image via the file input type
$f3->route('GET /simpleform',
  function($f3) {
    $f3->set('html_title','Simple Input Form');
    $f3->set('content','simpleform.html');
    echo template::instance()->render('layout.html');
  }
);

// When using POST (e.g.  form is submitted), invoke the controller, which will process
// any data then return info we want to display. We display
// the info here via the response.html template
$f3->route('POST /simpleform',
  function($f3) {
	$formdata = array();			// array to pass on the entered data in
	$formdata["name"] = $f3->get('POST.name');			// whatever was called "name" on the form
	$formdata["colour"] = $f3->get('POST.colour');		// whatever was called "colour" on the form

  	$controller = new SimpleControllerAjax;
    $controller->putIntoDatabase($formdata);

	$f3->set('formData',$formdata);		// set info in F3 variable for access in response template

    $f3->set('html_title','Simple Example Response');
	$f3->set('content','response.html');
	echo template::instance()->render('layout.html');
  }
);

// When using GET, provide a form for the user to upload an image via the file input type
$f3->route('GET /hint',
    function($f3) {
        $f3->set('html_title','Simple Input Form');
        $f3->set('content','ajaxEx.html');
        echo template::instance()->render('layout.html');
    }
);

$f3->route('GET /ajaxEx/user/@query',
  function($f3) {
  	$q = $f3->get('PARAMS.query');
  	$controller = new SimpleControllerAjax;
    $userTable = $controller->getUserTable($q);
    $f3->set('userTable',$userTable);
    echo template::instance()->render('ajaxTable.html');
  }
);

$f3->route('GET /ajaxEx/hint/@query',
  function($f3) {
  	$str = $f3->get('PARAMS.query');		// query should be a string of at least one character
  	$controller = new SimpleControllerAjax;
    $userHint = $controller->getUserHint($str);
	echo $userHint;
  }
);

$f3->route('POST /ajaxEx/user',		// NB POST here: will be reached by form submission
  function($f3) {
  	$str = $f3->get('POST.LastName');
  	$controller = new SimpleControllerAjax;
    $userTable = $controller->getUserTableFromStr($str);
    $f3->set('userTable',$userTable);
    echo template::instance()->render('ajaxTable.html');
  }
);


// When using

$f3->route('GET /dataView',
  function($f3) {
  	$controller = new SimpleControllerAjax;
    $alldata = $controller->getData();

    $f3->set("dbData", $alldata);
    $f3->set('html_title','Viewing the data');
    $f3->set('content','dataView.html');
    echo template::instance()->render('layout.html');
  }
);

$f3->route('POST /searchView',
  function($f3) {
  	$controller = new SimpleControllerAjax;
    $alldata = $controller->search($f3->get("POST.field"), $f3->get("POST.term"));
    echo $alldata;
  }
);


$f3->route('GET /searchView', // GET query with ?field=VALUE&term=VALUE
  function($f3) {
  	$controller = new SimpleControllerAjax;

    $alldata = $controller->search($f3->get("GET.field"), $f3->get("GET.term"));
    $f3->set("dbData", $alldata);
    $f3->set('html_title','Viewing the data');
    $f3->set('content','dataView.html');
    echo template::instance()->render('layout.html');
  }
);


$f3->route('POST /dataView',
  function($f3) {
  	$controller = new SimpleControllerAjax;
    $alldata = $controller->search($f3->get('POST.field'), $f3->get('POST.term'));

    $f3->set("dbData", $alldata);
    $f3->set('html_title','Viewing the data');
    $f3->set('content','dataView.html');
    echo template::instance()->render('layout.html');
  }
);

$f3->route('GET /editView',				// exactly the same as dataView, apart from the template used
  function($f3) {
  	$controller = new SimpleControllerAjax;
    $alldata = $controller->getData();

    $f3->set("dbData", $alldata);
    $f3->set('html_title','Viewing the data');
    $f3->set('content','editView.html');
    echo template::instance()->render('layout.html');
  }
);

$f3->route('POST /editView',		// this is used when the form is submitted, i.e. method is POST
  function($f3) {
  	$controller = new SimpleControllerAjax;
    $controller->deleteHandler($f3->get('POST.toDelete'));		// in this case, delete selected data record

	$f3->reroute('/editView');  }		// will show edited data (GET route)
);


  ////////////////////////
 // Run the FFF engine //
////////////////////////

$f3->run();


---
layout: page
title: Dynamic Web Design Setup and Workflow
---


Resources for setting up your server, working with PHPStorm and collaborating in your groups.


## Workflow

In short, the suggested workflow is

- Copy The F3 Simple Example to your server so that it is at `public_html/fatfree/F3SimpleExample` [download here]
- Follow setup for:
    - F3 setup
    - Database setup


## How to Debug and Ask Questions

Cribbed heavily from [How do I ask a good question?](https://stackoverflow.com/help/how-to-ask) and [How to create a Minimal, Reproducible Example](https://stackoverflow.com/help/minimal-reproducible-example)

- Create a minimal, complete, reproducible example
  - **Minimal** – Use as little code as possible that still produces the same problem
      1. Restart from scratch. Create a new page, adding in only what is needed to see the problem. Use simple, descriptive names for functions and variables – don’t copy the names you’re using in your existing code.
      2. Divide and conquer. If you’re not sure what the source of the problem is, start removing code a bit at a time until the problem disappears – then add the last part back.
  - **Complete** – Provide all parts someone else needs to reproduce your problem in the question itself
      - If the problem requires HTML, some JavaScript, and a stylesheet, include code for all three. The problem might not be in the code that you think it is in.

  - **Reproducible** – Test the code you're about to provide to make sure it reproduces the problem
      - Describe the problem. "It doesn't work" isn't descriptive enough to help people understand your problem. Instead, explain what the expected behaviour should be.
      - Eliminate any issues that aren't relevant to the problem.
      - Double-check that your example reproduces the problem
- **DO NOT** post images of code, data, error messages, etc.
    - copy or type the text into the question.
    - share with http://jsfiddle.net or http://codepen.io or http://plnkr.co or on you server
- Write a title that summaries the specific problem
    - If you're having trouble summarising the problem, write the title last - sometimes writing the rest of the question first can make it easier to describe the problem.
- Include any error messages, key APIs



## Snippets

### PHP

#### Pretty Print

```html
<h1>Pretty Print Variable</h1>
<pre>
    {{@VAR_TO_PRINT}}
</pre>
```

```php
function pprint_var($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

// Example F3 Routing
// This dumps out the contents of the Database object
$f3->route('GET /test',
    function ($f3)
    {
        $db = $f3['DB'];
        $f3->set('VAR_TO_PRINT', pprint_var($db));
        $f3->set('content','testView.html');
        echo Template::instance()->render('layout.html');
    }
);
```

#### Print to Console


**testView.html**

```html
<h1>Pretty Print Variable</h1>
<p>
  Check your Developer Console!
</p>
```

At the bottom of your **index.php**:

```
function pprint_var($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

function print_to_console( $data )
{
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

// Example F3 Routing
// This dumps out the contents of the Database object
$f3->route('GET /test',
    function ($f3)
    {
        $db = $f3['DB'];
        print_to_console(pprint_var($db))
        $f3->set('content','testView.html');
        echo Template::instance()->render('layout.html');
    }
);
```

#### F3 Error Handling

The F3 documentation on custom error pages is a little obfuscated

https://fatfreeframework.com/3.7/framework-variables#AbouttheF3ErrorHandler

A custom error page is generally a nicer user experience, plus it will let you easily know if you are getting a server error or something like a simple 404 not found

Create some kind of error page

**error.html**

```html
<h1>Whoops! {{@ERROR.text}} {{@ERROR.status}}</h1>
<p>Error code: {{@ERROR.code}}</p>
<h2>Error Dump</h2>
<pre>{{@DUMP}}</pre>
```

in **index.php** (see above for `pprint_var` code)

```php
$f3->set('ONERROR',function($f3){
    $f3->set('html_title',$f3['ERROR']['code']);
    $f3->set('DUMP',pprint_var($f3['ERROR']));
    $f3->set('content','error.html');
    echo template::instance()->render('layout.html');
});
```

### JavaScript

#### Simple Ajax

```js
function simplQuery(requestUrl)
{
    $.ajax({
        type: 'GET',
        url: 'requestUrl',
        success: response => console.log(response),
        failure: error    => console.log(error);
    });
}
simplQuery('http://date.jsontest.com')
```

## Links

- [PHPStorm F3 Snippets](https://github.com/ikkez/F3-PhpStorm-Snippets)

    Copy `F3.xml` to the `templates` folder or create one if it does not exist in:

    - Windows: `<your home directory>\.PhpStorm<version>\config\templates`
    - Linux: `~/.PhpStorm<version>/config/templates`
    - MacOS: `~/Library/Preferences/PhpStorm<version>/templates`

    Copy `F3_Codestyle.xml` to the `codestyles` directory

    - Windows: `<your home directory>\.PhpStorm<version>\config\codestyles`
    - Linux:   `~/.PhpStorm<version>/config/codestyles`
    - MacOS:   `~/Library/Preferences/PhpStorm<version>/codestyles`

- If you must check StackOverflow, be smart and search by tag and votes, e.g. https://stackoverflow.com/questions/tagged/fat-free-framework?tab=Votes


### JavaScript Libraries


- [P5.js](https://p5js.org) is buckets of fun, and a good interface for [WebAudio](https://developer.mozilla.org/en-US/docs/Web/API/Web_Audio_API) alone.
- [Threejs](https://threejs.org) for 3d work
- [BokehJs](https://docs.bokeh.org/en/latest/docs/dev_guide/bokehjs.html) for data visualisation
- [Leaflet](https://leafletjs.com) for maps

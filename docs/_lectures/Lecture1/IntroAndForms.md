---
layout: page
title: Server-side systems and database serving
author: "John Lee"
---

- [Introduction](#introduction)
- [The role of the server](#the-role-of-the-server)
- [CGI](#cgi)
- [The HTTP request methods](#the-http-request-methods)
- [Forms](#forms)
- [The processing script](#the-processing-script)
- [PHP](#php)
- [Today's date is 15/01/2014](#todays-date-is-15012014)
- [Forms in PHP](#forms-in-php)
  - [The $_GET array](#the-get-array)

## Introduction

Dynamic web sites are everywhere. Very few are static HTML pages.
E-commerce systems are dynamic; catalogues, searches, registration/login
systems, shopping baskets, message boards, surveys, systems with
cookies, RSS feeds -- all these are dynamic. We need to understand how
to create and control them for ourselves.

Dynamic web sites are all about change: change not just in the way
information is displayed (which we can achieve in the browser with
Javascript, Flash, etc.), but change in the information itself.
Information may be dynamically substituted with other information, or
dynamically created from some other resource. This can only be done at
the source of the information: the web server.

So in this course, we begin by turning our focus away from the web
user's browser for a while, to consider the role of the web *server*[
in an interaction, and how we can use this to provide for different
kinds of functionality. In particular, we look at how information can be
obtained from the user by means of *form-filling*, and we begin to look
at how it can be processed once we've got it.
]{style="font-style:normal"}

[We develop this line of discussion by starting to look at the use of
*databases* and how they can be integrated to provide dynamic
information through web sites. These are the techniques and technologies
used by most commercial web sites, and this course should equip you to
understand how these are created, and develop sites of these kinds for
yourself. ]{style="font-style:normal"}We will start by considering the
simplest kinds of web technologies and then move on to look at a system
called PHP, which we will use in this course as our choice from a range
of possible technologies with similar capabilities.

As ever in this programme, we are not aiming to do more in the lectures
than introduce these things: it is up to you to pursue further resources
to find more information and move to a more advanced level.

## The role of the server

When you look at a web page, what actually happens is that your browser
connects to a server, specified in the first part of the URL, and sends
the server a *request*[, which includes the whole URL. The server
provides (i.e. ]{style="font-style:normal"}*serves*[) a specific
document, specified by the rest of the URL. ]{style="font-style:normal"}

[The document (which is usually just a file full of some kind of data)
is downloaded onto your machine, and the browser identifies its
***type***, usually through information in a "header" sent by the server
(see below), which normally relates to the file extension, ".html"
etc. (but the header often takes precedence if the file extension is
different). If it's HTML, or plain text, or a few other things, the
browser will attempt to display it using its own resources; or it may
offer it as input to a plugin; otherwise it may launch a helper
application or just save the file somewhere. (Usually browser
"preferences" determine how various kinds of document are handled; see
also
<http://en.wikipedia.org/wiki/Internet_media_type>.)]{style="font-style:normal"}

[Sometimes, the document requested by the browser does not already exist
on the server machine, at least not in the required form. In that case,
the request may fail, but alternatively the server may have been given
instructions to do some processing to create or modify the document
before serving it. ]{style="font-style:normal"}

[The HyperText Transfer Protocol (HTTP), which web applications
typically use to communicate, is how requests are expressed when the URL
begins with "http:", and it allows one to specify some aspects of how
the server should behave. ]{style="font-style:normal"}

## CGI

The "Common Gateway Interface" is a standard mechanism whereby the
server can be made to execute some application on the server machine,
and provide any result from the application as data to be sent back to
the originator of the request.

The server will execute the application; it will also pass as a
***parameter***[ to the application any component of the URL that
follows a "**?**" character. Thus, if you visit the Google search site
(<http://www.google.com/>) and execute a search for
]{style="font-style:normal"}*MSc Design Digital Media*[, you'll notice
that the URL in the browser changes to something like the
following:]{style="font-style:normal"}

`http://www.google.com/search?hl=en&q=MSc+Design+Digital+Media&btnG=Google+Search`

In this URL, *search,* just before the "*?*", [ will be the name of
some application on the Google server machine, and the string
]{style="font-style:normal"}*hl=en&q=MSc+Design+Digital+Media&btnG=Google+Search*
[is what's handed to it as a parameter. ]{style="font-style:normal"}

[By convention, this parameter string (often called the "*query
string*") consists of a list of named parameters (in this case three:
]{style="font-style:normal"}*h1, q,* and *btnG*[) and their values,
linked by "=". The parameter-value pairs are separated by "&".
Within parameter values, words are separated with the "+"
character.]{style="font-style:normal"}

[Spaces are not allowed: any such non-alphanumeric characters are
represented by "%" and then their ASCII code as a two-digit
hexadecimal number, so if spaces do appear they are encoded as "%20".
(This arrangement is called ]{style="font-style:normal"}*URL encoding*[,
and has to be used in all URLs, though many browsers will encode URLs
before sending them if you just type them in
directly.)]{style="font-style:normal"}

## The HTTP request methods

When a request is sent to a server, a ***method***[ is specified for
handling any data associated with the request. Usually, this is either
GET or POST. The former of these is notionally associated with getting
information from the server, while the latter is associated with posting
data to it; however these are often not very distinct. Either way, some
facility is available for the server to obtain information from the
browser, which may then be somehow processed (and then probably other
information will be sent back as a response).
]{style="font-style:normal"}

[In the case of *forms*, the browser is in fact providing data to the
server, but it can do this using either GET or POST methods -- the
information is simply sent in different ways. We will normally use the
POST method for form data, because it has some security
advantages.]{style="font-style:normal"}

## Forms

HTML forms are, at their simplest, just a quick and convenient way of
adding information to an HTTP request. For example, they can be used to
construct a query string for a CGI URL.

Suppose we have an application on our server that saves people's names
in a file, and the application is called *namesave.cgi*[. If one
executes it with a name as parameter, it will add the name to a file. We
could have the user always type in a URL ending
with]{style="font-style:normal"}

[.../namesave.cgi?name=John+Smith]{style="font-family:Courier"}

(or whatever their name might be), but this is not at all convenient.
Usually the user would be put off by this, and it is more practical, as
well as more attractive and simpler, to provide instead an HTML form as
follows.

` <html> <head> <title>Simple example form</title> </head> <body> <h1>An example of a very simple form</h1>  <p>  <form method="GET" action="namesave.cgi">  Enter your name here:    <input type="text" name="name">  <input type="submit">  <input type="reset">  </form>  </body>  </html>`

When this HTML is displayed, it looks as follows ([or as at this
link](http://ddm.caad.ed.ac.uk/lectures/DDM/Intro_Digital_Media/Lecture11/simpleform.html)):

![](Lecture1notes_files/image002.jpg){width="395" height="129"}

And when the Submit button is clicked, the URL changes to the one shown
above, i.e. it ends in *namesave.cgi* (and what comes before that
depends on the URL of the form itself, because in the HTML of the form
*action* attribute we have used a *relative link --* relative and
absolute links work in forms just the same way as anywhere else). [NB,
the application in this example is now a dummy, so you'll get a
"permission denied" message when you try to execute it, but you can
still see what happens to the URL.]

This principle can be extended, in that there are a considerable range
of types of input available (lists, buttons, checkboxes, etc.), and
clearly the URL produced can become very complicated, but the mechanism
remains the same.

Editors such as Dreamweaver make the creation of forms very simple. The
trickier part comes when you want to do something with the data they
create. The basic mechanism is fairly simple: the "form" tag specifies
through its "action" attribute a CGI application that will be used by
the server to process the form data, and the method (GET or POST) will
be as specified by the "method" attribute:

` <form method="GET" action="namesave.cgi">`

All you need to do, then, is decide what application to use and create a
program that handles the data appropriately.

The most obvious difference between GET and POST, in practice, is that
whereas the GET method sends parameters via the URL as described above,
POST causes the information to be sent in a different way, which is not
visible on the URL.[  ]{style="mso-spacerun: yes"}We have chosen to use
GET here for clarity, but obviously POST may have advantages in some
situations. The application that processes the data will also have to
decode it differently depending on which of these methods is used, and
decoding POST information is more complicated. (With PHP, as we'll see
below, we normally use POST for form data, but we will not need to know
the details of how PHP decodes it.)

Remember that the URL query string can be used even wihout forms, to
provide information for an application such as ColdFusion. This will
continue to be important for us.

We are concerned here only with the "back-end" processing of form
data, but the appearance and behaviour of the form for the user is of
course also very important. HTML5 provides many useful features in this
respecty and is now the best choice for form development (see the Forms
chapter in the excellent *Dive into HTML5* for explanation and examples
--- <http://diveintohtml5.info/forms.html>).

## The processing script

The application program you create to handle form data could be almost
anything that can be run on the server machine. You could write it in C,
Java, Prolog, Applescript, Visual Basic, FileMaker Pro or various other
things that might be available. The key factor is that the server runs
the application in an *environment* where it is provided with the values
for various variables as part of the CGI interface, which includes the
query string, along with things like the user's IP number, the kind of
browser they're using, etc.

Often, however, form data is processed by some system that is more
integrated with the task of producing HTML pages from other data. Such
systems are PHP, ASP, JSP, Coldfusion, and others. These can all be used
for a range of CGI-related purposes. We are going to use PHP, which is
just one example. You are welcome to look at and compare the others if
you want. (PHP can be used on our own server -- details follow. A
Coldfusion server is operated by Information Services, to which access
can be arranged. ASP is normally available only on Windows-based
servers, but the others are supported on various platforms.)

What happens with all of these systems is that you write *templates*,
which are HTML pages that have instructions of some kind embedded in
them. The server processes the template by removing the instructions and
replacing them with more HTML that the instructions tell it how to
create, often using data or other resources that may be different at
different times. Hence the final page that the user sees is created
*dynamically* just at the moment it is asked for, and so it can be
updated in many ways that would be impossible with a static page.

## PHP

We have chosen PHP mainly because it is free, open source software and
very widely used. It is also extremely powerful. Its development history
is well described at <http://uk.php.net/manual/en/history.php>. It has a
comprehensive manual, as well as tutorials and other material, on its
own web site at <http://uk.php.net/docs.php>. It is also well integrated
with Dreamweaver for editing and design purposes.

You can install PHP on your own computer (e.g. laptop), along with the
MySQL database and the Apache web server, in the form of a neatly
packaged setup called (if you are using a Macintosh) MAMP
([www.mamp.info/](www.mamp.info/)). This stands for "Macintosh, Apache,
MySQL, PHP", and derives from the original LAMP, which is for the Linux
operating system. There is also WAMP or WampServer for Windows machines.
We do not undertake to support students in running any setup on their
own machines: if you wish to try it, this is up to you. We provide
access to all the components on the studio systems, as described [at
this link](additional14.html).

PHP defines a language written between tags that are placed within HTML
pages. The tags open with "***<?php***", and close with
"***?>***"; they are embedded in ordinary HTML pages that are placed
on a machine with a special PHP web server (which is often an extension
of the server that serves plain HTML web pages). These pages are
sometimes known as *templates*. When they are served by the server, *all
the PHP code, with its tags, disappears* and is replaced by pieces of
HTML that depend on what the PHP statements specified. The resulting
page is therefore interpretable by any normal browser. If you look at
the HTML source of any PHP page as it arrives at your browser, you wil
find nothing other than ordinary HTML, CSS etc. With this kind of
system, the pages can be designed exactly as usual, but with these PHP
tags as placeholders for material that will be provided dynamically when
the page is viewed in the user's browser.

So there is no PHP user interface: you design your page templates using
Dreamweaver, or any other text editor, and you include PHP script
elements into the HTML. Dreamweaver and some other editors will have
functionality that helps you to do this, but you don't have to use it.
Your template contains nothing but text. Then you place the templates
onto the PHP server and access them via a web browser, like any other
web pages.

Some of the examples used in what follows are actually based on ones in
the book *Programming in Cold Fusion* by Rob Brooks-Bilson (O'Reilly,
2001), because we originally used ColdFusion in this course, but they
have been rewritten to use PHP. This emphasises that these systems all
do the same thing, even if they do it in slightly different ways. There
are many similar books on PHP, and even more material on the web --- a
good introduction can be found, as usual, [at
w3schools.com](http://www.w3schools.com/php/), but unfortunately they do
not use the database connection method that we'll be using here (see
later), so ***do not follow their examples on using databases***.

There are plenty of things you can do with PHP without needing to use a
database. Here's a simple example of a template. (Note that I am
following the terminology of referring to the whole code of the page as
a *template*; sometimes I might call it a *page*. I will refer to the
parts **within the PHP tags** as *script* elements, or simply *the PHP
script*. This is not necessarily the same terminology as you will find
elsewhere, but I think it's clearer if used consistently.)

`<HTML>   <HEAD>   <TITLE>PHP Example</TITLE>   </HEAD>   /<BODY>   <H2>Today's date is   ``<?php     echo date("d/m/Y");   ``?>   </H2>   </BODY>   </HTML>`

This is clearly HTML with just the embedded PHP tags. Within the scope
of these tags, everything is taken to be PHP code that should be
evaluated. In this case, the result of the evaluation (which is today's
date) is simply inserted into the HTML page and handed to the user's
browser. What appears on the browser (at the time of editing these
notes) is simply:

## Today's date is 15/01/2014

(Try <http://playground.eca.ed.ac.uk/~jlee/test/date.php>. See if you
can guess how to make it put the day before the month!)

The processing of this template is illustrated in the following diagram
(click for larger version).

[![PHP processing diagram](img/PHP-process)

*Always remember that the PHP script is only processed if the template
is **requested from the server**, i.e. if you use a browser and **a URL
that begins with http://** ... If you access the template file
**directly** with a browser (in which case your URL will begin
**file://**) then the script will **not** be processed and so you will
**not** see the result you expect.*

This is the basic idea behind PHP, which means "PHP: Hypertext
Preprocessor" --- it pre-processes your web pages in various ways
before they are served to the user. PHP has a very wide range of
capabilities and can be used for a great many things. Here we'll talk
mainly about forms and databases, but there is also support for email,
searching, http connectivity, security and encryption, graphing and
charting, and more advanced scripting. See the many books available (or
the PHP web site, which has very good documentation) for details. Good
online documentation and reference material for PHP is also built into
Dreamweaver (*Reference* under the *Help* menu, then see *O'REILLY PHP
Pocket Reference*).

## Forms in PHP

A simple example of a form that provides data which is processed and
then just printed out (not put into a DB or anything like that) is this
simple "currency converter", which is *a form that gets posted to
itself* -- a very useful technique in many situations. This HTML form
is in a file called "convert.php"
([<http://playground.eca.ed.ac.uk/~jlee/test/convert.php>]{.style10}):

    <html>
    <head>
    <title>Untitled Document</title>
    </head>
    <body>
    <h2>Currency converter</h2>
    <form name="form1" method="post" action="convert.php">
    <p> Source currency:
       <input type="text" name="Source">
    </p>
    <p> Conversion rate:
    <input type="text" name="Rate">
    </p>
    <p>
    <input type="submit" name="Submit" value="Submit">
    </p>
    </form>
    <?php
     if (isset($_POST["Submit"])) {
        $result=$_POST["Source"]*$_POST["Rate"];
    ?>
    <h2>The result is:
    <?php
        echo $result;
    ?>
    in the target currency.</h2>
    <?php
     }
    ?>
    </body>
    </html>

The colours are just to help me in referring to the code. Notice the use
of *if* (in the blue part, which is the PHP script) for conditional
processing: PHP has a full range of conditional constructions like
these, which work much the same as in Actionscript, Javascript, or other
programming languages.

Notice also the use of the POST method in the form action (highlighted
in red). This makes variables that correspond to the input fields in the
form available to the PHP template as members of the *$_POST*
***array***, accessed as *$_POST["Submit"], $_POST["Rate"]*,
and so on.

Notice that PHP variables normally start with the character *$*. This
is quite different from Actionscript. You don't need a keyword such as
*var*, and the variables don't have to be declared before they are
used.

In PHP an array may be similar to arrays in other languages, and indexed
simply by a number, or it might be an *associative array* like the
*$_POST* array here. In this type of array, each value is associated
with a key that can be used to retrieve it, so here for instance the key
"Rate" is associated with whatever value was entered by the user in
the *Rate* field of the form we created. In PHP, the keys are strings,
hence the quotes around them (which can be either single or double
quotes). The *$_POST* array will contain anything the PHP script has
received via an HTTP POST request, in this case being the material
submitted from the form.

Remember that when a URL appears as the *ACTION* of a form, it will be
called as normal but given a CGI environment with the form variables in
it. Whenever a PHP template is called as the script in a form *ACTION
(*if the method is *POST*), a *$_POST* array is created as part of the
environment. In that array, the item determined by the submit button in
the HTML definition of the form (here highlighted in purple) is always
defined, or "set". In this case it's simply called *Submit* (which
will be accessed as *$_POST["Submit"]*). Hence the **function**
*isset($_POST["Submit"])* will return as true if and only if it is
tested when the template is called by being the *ACTION* of a form.

When we simply visit the URL
<http://playground.eca.ed.ac.uk/~jlee/test/convert.php> in a browser, it
is not being called by a form, so *$_POST["Submit"]* is not
***set***, and so nothing in the template between the opening and
closing "curly brackets" of the PHP conditional block is processed or
output: all we see is the form itself. But when we click on the submit
button, **the same URL is called, but this time as the form *ACTION***,
and so *$_POST["Submit"]* ***is set***, the part of the template
highlghted in blue (including the green) is processed, and the rest of
the HTML (the statement of the result) therefore appears.

This technique of having the form call itself (having the form ACTION be
the form itself) is very common and useful . However, it is also common
to have templates that are used ***only*** as form actions, as pure CGI
scripts, and ***never*** called directly in the browser -- an example,
displaying the results of a database query, appears below.

Notice that, with PHP as with most other systems, there are multiple
ways of achieving the same thing. The template we have just looked at
interweaves PHP code and HTML in a potentially confusing way. Often, PHP
developers will output some of the HTML from within the PHP script
elements, which makes the overall template simpler and more compact. We
could replace the whole part in blue and green, in the above template,
with simply the following:

    <?php
     if (isset($_POST["Submit"])) {
       $result=$_POST["Source"]*$_POST["Rate"];
       echo "<h2>The result is: ";
       echo $result;
       echo " in the target currency.</h2>n";
     }
    ?>

Here, the PHP *echo* statements output the HTML instead of it being in
the material outside the script. (The "n" is just a new line in the
output --- not really necessary but it will make the output page HTML
source more readable if you need to debug it.) One could also make this
even more succinct by combining the three *echo* statements into one, by
using the "*."* operator (which concatenates strings in the same way
as the *"+"* operator in e.g. Actionscript):

``` {.style7}
<?php
 if (isset($_POST["Submit"])) {
   $result=$_POST["Source"]*$_POST["Rate"];
   echo "<h2>The result is: " . $result . " in the target currency.</h2>n";
 }
?>
```

Below, we will notice yet another way of obtaining the same output using
the function *printf()*. It is usually the case with PHP that there are
several ways of achieving the same result.

### The $_GET array

Variables that are provided to a template in a query string as part of
the URL (or from a form that uses the HTTP GET method) are also made
very simply and directly available, similarly to POST variables, as
members of a standard array called *$_GET*. Thus if we have a template
called as *template?var=val* then in the template itself we can access
*$_GET["var"]* and discover that its value is *val*.

A tutorial on creating a form is also available at
<http://playground.eca.ed.ac.uk/~jlee/PHP-FormTutorial/>

---
layout: page
title: Additional thoughts on PHP
author: "John Lee"
---

## Conditional expressions

A handy construct in PHP, which allows you to use conditionals without
having lots of clumsy "if ... then" constructions, is the following
kind of *conditiona*l _expression_:
```js
    (condition)?(what if true):(what if false)
```
--- where the brackets are optional if there is no ambiguity.

Consider this
(<http://playground.eca.ed.ac.uk/~jlee/test/urltest.php>[](http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/cfboxtest.cfm)):
```php
    <?php
     echo "The first message given on the URL was <font color=red>" . (isset($_GET["message1"])?$_GET["message1"]:"not specified") . "</font> ...<br />";
     echo "The second message was <font color=red>" . ($_GET["message2"]?$_GET["message2"]:"not specified") . "</font>n";
    ?>
```
(It's an old example: such use of the _font_ tag is deprecated now --
use CSS for anything like this.)

The part highlighted in red says that if the URL parameter _message1_ is
set, then it should be echoed, otherwise the string "not specified"
should be. The part in green says the same about _message2_, but
without using _isset()_. What happens in this case depends on how the
PHP server is set up. On my local machine, _\$\_GET["message2"]_
will evaluate to FALSE if the paramter is not set, so that _isset()_ can
be omitted. However, on the _playground_ server, there is a check for
undefined parameters, and so you will get an error in this case.
Therefore you should always use the _isset()_ test when working with URL
parameters, so that your code remains safe and portable.

Notice that the whole conditional expression is enclosed in brackets.
This is necessary, because otherwise the scope of the conditional
includes the initial _echo_, which is clearly too wide.

This kind of conditional expression is often useful when assembling
strings for output, e.g. as in:
```php
    echo "You ordered " . $n . " item" . ($n==1?"":"s") . "n";
```
which simply says "You ordered 1 item", if _\$n_ is 1, or else e.g.
"You ordered 23 items" if _\$n_ is not 1. A small consideration, but
little things like this can make an interface seem much more natural and
would be far more clumsy to code without this handy little expression.
It's worth noting that the expression is inherited from C, and exists
also in C++, Java, Actionscript, Javascript, etc.

## In the Fat-Free Framework (F3)

When we are using F3, the framework itself provides its own versions of
the global PHP environment variables such as _\$\_GET_, and a function
_\$f3->exists()_ to test them. You don't have to use these, since the
normal PHP mechanism will still work, but the F3 code is arguably neater
and easier to work with. To realise the present example in F3, you could
get away with not using a template, since the output page is so minimal;
we can just echo the output from the routing code. In your index.php
file, you would set the usual $f3 variable for F3 itself, and perhaps
DEBUG, and of course have *$f3->(run)\* at the end. Or you could drop
the following code into any F3 index.php file, such as the SimpleExample
one. So you could define a route, let's say for a URL ending in
"/urltest", such as:
```php
$f3->route('GET /urltest',
  function($f3)
  {
    echo "The first message given on the URL was <font color=red>".($f3->exists("GET.message1") ? $f3->get("GET.message1") : "not specified").
    "</font> ...<br />";
    echo "The second message was <font color=red>".($f3 -> exists("GET.message2") ? $f3 -> get("GET.message2") : "not specified").
    "</font>n";
  }
);
```
It works just the same as the vanilla PHP version.

In F3, it would be natural to use a template for situations such as the
checkbox examples below, but otherwise the same considerations apply. It
would be a useful exercise to reconstruct these examples using an F3
template. Here's a hint: in F3 you can embed expressions within
templates (see <https://fatfreeframework.com/3.6/views-and-templates>,
which is highly recommended reading). So instead of a line like:
```php
<input type="checkbox" name="checkIt" id="checkbox" [<?php echo
isset(\$\_POST["checkIt"])?"checked":"";?>]{.style8} />
```
you could have:

```php
<input type="checkbox" name="checkIt" id="checkbox" [{{
@POST.checkIt?"checked":"" }}]{.style8} />
```
which is much neater and more readable than the bare PHP version.

## Checking data types

The above example noted that PHP may be very forgiving if parameters are
not set, often evaluating them to 0 rather than producing an error. In
the same way, the "currency converter" example we had before
(<http://playground.eca.ed.ac.uk/~jlee/test/convert.php>) will quietly
produce an output of 0 if nothing at all is entered in the boxes, or if
letters are entered instead of numbers! In general, PHP will tend to
convert between data types such as strings and numbers, so that
operations like multiplying them together appear to work without
problems. For instance, _echo 23_"fish"* will simply output 0. But of
course, you may get unpredictable results in such situations, and it's
best to be as careful as you can to check that you are using appropriate
data. One way to do this is by using functions such as *is_numeric()\*,
and others that you can find listed at
<http://www.php.net/manual/en/ref.var.php>.

## Checkboxes

Another useful context for conditionals is where you are using
checkboxes on a form. These can be confusing because if the box is
checked then its value will (by default) be the string "on", whereas
if the box is not checked on the form, then the corresponding _\$\_POST_
variable is _unset_, so if you try to use it you will get either an
error or an empty string (depending on how your server is configured).

Consider this situation
(<http://playground.eca.ed.ac.uk/~jlee/test/boxtest.php>[](http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/cfboxtest.cfm)):

```html
<form id="form1" name="form1" method="post" action="">
  <p>Check box:
    <input type="checkbox" name="checkIt" id="checkbox" />
  </p>
  <p>
    <input type="submit" name="Submit" id="button" value="Update" />
  </p>
</form>
<p>
  <?php
echo "Value of checkbox is " . $_POST["checkIt"];
?>
```
Here, you'll find that if the box is checked, the value is "on", but
if it isn't you get an error, or at least an incomplete sentence. The
simplest way to fix this would be to use a conditional expression:
```php
<?php
echo "Value of checkbox is " .
    [(isset($_POST["checkIt"])?"on":"off")]{.style8};
?>
```
(or use whatever other strings you like instead of "on" and "off")
then the problem is resolved fairly elegantly
(<http://playground.eca.ed.ac.uk/~jlee/test/boxtest2.php>[](http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/cfboxtest.cfm)).

But this still looks odd to the user, since the text doesn't always
correspond to the state of the checkbox just after they click the
button. Better still, we can use a test for whether the box is checked
at the point where the box is created on the form, and if so have it
checked already when it appears. In this way, the state of the box
remains as the user tends to expect
(<http://playground.eca.ed.ac.uk/~jlee/test/boxtest3.php>):
```php
<body>
  <form id="form1" name="form1" method="post" action="">
    <p>Check box:
      <input type="checkbox" name="checkIt" id="checkbox" [<?php echo
isset($_POST["checkIt"])?"checked":"";?>]{.style8} />
    </p>
    <p>
      <input type="submit" name="Submit" id="button" value="Update" />
    </p>
  </form>
  <p>
<?php
echo "Value of checkbox is " .
(isset($_POST["checkIt"])?"on":"off");
?>
```
Notice that if you want "on" (the actual value returned from the form)
to be something else, say "set", then you can add _value="set"_ as a
attribute to the input of type checkbox, but in the code we have here we
are never looking at the actual value returned in
_\$\_POST["checkIt"]_, so it doesn't matter.

Of course, there are many situations where we want a form to appear with
values already in it, and this is often a useful technique when getting
that to happen.

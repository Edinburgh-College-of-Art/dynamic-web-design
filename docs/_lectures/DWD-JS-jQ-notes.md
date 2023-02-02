---
layout: page
title: Javascript and jQuery
author: "John Lee"
order: 36
week: 3
---

-   [Introduction to JavaScript](#introduction-to-javascript)
-   [One thing to note](#one-thing-to-note)
    -   [Javascript and Objects](#javascript-and-objects)
    -   [Javascript and Functions](#javascript-and-functions)
    -   [jQuery](#jquery)

## Introduction to JavaScript

In these notes I assume familiarity with the basic syntax etc. of javascript. It's quite similar to various programming or scripting languages you might have come across, including PHP (but with some important differences, e.g. variables don't normally start with "\$"). I will refer heavily to some external resources such as the w3schools pages, which on these topics are very good, and their "Try it yourself" feature is invaluable for experimenting.

**_Do always experiment!_** Try different things; try things you think will work and things you think won't -- try to find out why they don't. You can't break anything. Experiment _until you understand_. If you can't see why something does or doesn't work, do ask me or post to the Message Board (or search e.g. <http://stackoverflow.com> and other online resources).

I focus here on objects and functions because these are especially important in jQuery.

## One thing to note

It's very often useful to get output from your code to see what it's doing. You don't want to use _document.write()_, or similar, to output this to the web page. Instead, _console.log()_ will allow you to write messages to the javascript error console, available in all browsers, often from the "Develop" or "Tools" menu. _console.log()_ takes up to two arguments:

```js
var x=327;
console.log("This message will be followed by the value of the next argument: ", x);
```

does what you would expect. Use it often; it's extremely valuable.

### Javascript and Objects

Almost everything in javascript is, or can be treated as, an _object_.

Objects have the usual kind of "dot-based" syntax, e.g. in _document.getElementById("box1")_ there is an object, _document_, which has a method, _getElementById()_, which in this case is called with the argument, a string, _"box1"_.

The document object has many properties and methods (<http://www.w3schools.com/jsref/dom_obj_document.asp>), as do many of the DOM objects.

First, here are some excellent notes by Mike Greer, a former DDM graduate and tutor with us for several years: <https://edinburgh-college-of-art.github.io/dynamic-web-design/javascript/the-dom.html>. These show the basic relationship between javascript and the HTML Document Object Model (DOM), which is central to everything that follows.

The document is just one object among many, and you can create your own. There are some good object examples at w3schools: <http://www.w3schools.com/js/js_objects.asp>

Note that defining objects using functions is powerful and flexible, but it's different from defining classes in e.g. Actionscript, or even PHP. Don't get these confused. The way you will use objects once you have them is very similar, but the way of defining them is not.

### Javascript and Functions

Functions in javascript are much as you will have seen in PHP: <http://www.w3schools.com/js/js_functions.asp>

But also, in javascript, functions can be _anonymous_ -- you can create a function, e.g. as a value of a variable, without giving it a name directly. (These are exactly like the anonymous functions in PHP that we have used in Fat Free Framework route rules, for example.)

This is often used to add methods to objects. Consider the example from <http://www.w3schools.com/js/tryit.asp?filename=tryjs_create_object3>: in this case, there is code that says:

```js
this.changeName = changeName;

function changeName(name)
{
  this.lastname = name;
}

```

What's happening here is that the variable changeName is being given the function that's also called changeName as a value. But we could equally well write the code like this:

```js
this.changeName = function(name)
{
  this.lastname = name;
}
```

(Try it and see!) This is the way you will see it more often done. The code is more compact, and (once you get used to it) easier to work with.

But also, anonymous functions like this can be e.g. given as arguments to other functions. Suppose we wanted to specify the changeName function as a _parameter_ of the object; then we could rewrite this example along the lines:

```js
function person(firstname, lastname, age, eyecolor, changefunc)
{
  this.firstname = firstname;
  this.lastname = lastname;
  this.age = age;
  this.eyecolor = eyecolor;

  this.changeName = changefunc;
}

myMother = new person("Sally", "Rally", 48, "green",
  function(n)
  {
    this.lastname = n
  });
myMother.changeName("Doe");
document.write(myMother.lastname);
```

So here, where we created the new person, we also specified the function for changing their name. The code in red is just an anonymous function definition, dropped in as a parameter to another function call. This isn't of much practical use here, but could be in a case where people's names might be changed in different ways, or something like that.

Play with some of these examples, and try out these ideas. One might modify the example to something like:

```js
function person(firstname, lastname, age, eyecolor,changefunc)
{
  this.firstname = firstname;
  this.lastname = lastname;
  this.age = age;
  this.eyecolor = eyecolor;

  this.changeName = changefunc;
}

myMother = new person("Sally", "Rally", 48, "green", function(n)
  {
    this.lastname = n
  });
myFather = new person("George", "Doe", 48, "green",
  function(n)
  {
    this.firstname = n
  });
myMother.changeName("Doe");
myFather.changeName("Fred");
document.write(myMother.lastname);
document.write(myFather.firstname);
```

\-- which outputs "DoeFred". Note that the functions supplied as the final parameter to the object are _different_: one changes the lastname, the other the firstname.

The syntax that results here is something you will see a lot of in javascript code -- especially once you start to tangle with jQuery ...

### jQuery

jQuery is just one among a number of libraries or frameworks available for javascript, but it's the most widely used and I've not come across a compelling reason to use another one. There is excellent introductory material at <http://www.w3schools.com/jquery/default.asp> -- note what it says there: "_jQuery is easy to learn_"!

One of the most difficult things about jQuery is the syntax, even though in reality it's fairly simple: <http://www.w3schools.com/jquery/jquery_syntax.asp>

Note that the "$" character is just the name of a function, but a crucially important one. In particular, it has nothing to do with variables and is not related to the "$" character as used in PHP!

It's really useful to get a clear idea of the range of selectors available: <http://www.w3schools.com/jquery/jquery_selectors.asp> (the "first", "even", "odd" etc. can be especially useful).

(The example of how to use the first-child selector, for instance, has a good example of embedded anonymous functions as commonly used in jQuery: <http://www.w3schools.com/jquery/tryit.asp?filename=tryjquery_sel_ullifirstchild>)

Again, anonymous functions are the usual approach to defining methods that will be called in response to interactive events: <http://www.w3schools.com/jquery/jquery_events.asp>

Here's an example of a small application that uses jQuery in an admittedly rather pointless way, but it shows up some of the techniques ([testJQsimple.html](testJQsimple.html)) -- the code is included here, but remember that as often with javascript you can also see it (formatted better than here) simply by viewing the page source (of testJQsimple.html) \[[footnote](#footnote)]:

```html
<style>
    #maindiv {
        color: blue;
    }

    #div2 {
        margin-top: 50px;
        margin-left: 50px;
        color: green;
    }

    #wddiv,
    #posdiv {
        color: red;
    }
</style>

<script>

    function setupWords() {
        var words = $("#wordarea").val();
        var wordsArray = words.split(" ");
        words = "";
        for (var i = 0; i < wordsArray.length; i++) {
            wordsArray[i] = "<span class='word' id = 'wd" + i + "' > " + wordsArray[i] + " < /span>";
            words = words + wordsArray[i] + " ";
        }
        console.log("words is ", words);

        document.getElementById("maindiv").innerHTML = words;
        $("#maindiv").html(words);
        setupjQ();
    }

    function setupjQ() {
        $(".word").mouseenter(function () {
            $(this).css("color", "red");
            has
            entered, red
            $("#wddiv").html($(this).html());
            $("#posdiv").html($(this).attr("id").substring(2));
            $("#div2").show();
        });

        $(".word").mouseleave(function () {
            $(this).css("color", "blue");
            $("#div2").hide();
        });
    }

    $(document).ready(function () {
        $("#div2").hide();
    });
</script>

<div id="maindiv">
    <!-- Textarea containing arbitrary text; the user can paste something
  else into this textarea if they want -->
    <textarea rows="10" cols="70" id="wordarea">
Of course, two SOMs connected in this fashion can learn no more or less than a single SOM would. But the stratification of the SOMs allows for processing to occur at intermediate stages. There are three types of intermediate processing that are relevant to the present discussion: activation decay, activation blurring, and multi-modal layers. Activation decay allows the activation of a given node to decay over time, rather than reset at each time step.
</textarea>
    <br/>
    <input type="button" onclick="setupWords()" value="Setup"/>
    <!--
  Button that will call setupWords() when clicked -->
</div>
<!-- div that will be hidden except when the mouse is over a word in
the text -->
<div id="div2">
    The current word is: <span id="wddiv"></span> at position
    <span id="posdiv"></span>
</div>
```

Footnote: I've subsequently noticed that the remarkable jQuery method `\$.each()` (see <https://api.jquery.com/jQuery.each/>) can be used to implement the `setupWords()` function above rather more succinctly as:

```js
function setupWords()
{
  var words = "";
  $.each($("#wordarea").val().split(" "), function(i, word)
  {
    words += "<span class='word' id='wd" + i + "'>" + word + "</span>
    ";
  });
  $("#maindiv").html(words);

  setupjQ();
}
```

This does exactly the same thing as the same function (coloured blue) in the code above. It's probably slightly more efficient to run; but perhaps a bit less readable!

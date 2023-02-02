---
layout: page
title: JQuery and AJAX
author: "John Lee"
order: 38
week: 3
---

This example expands on the [JQuery example](testJQsimple.html), but also adds an AJAX query to a dictionary API.

- Type some text below
- highlight a word with your mouse
- watch for the result

<div id="maindiv">
<!-- Textarea containing arbitrary text; the user can paste something else into this textarea if they want -->
<textarea rows="10" cols="70" id="wordarea">
Of course, two SOMs connected in this fashion can learn no more or less than a single SOM would. But the stratification of the SOMs allows for processing to occur at intermediate stages. There are three types of intermediate processing that are relevant to the present discussion: activation decay, activation blurring, and multi-modal layers. Activation decay allows the activation of a given node to decay over time, rather than reset at each time step.
</textarea>
<br />
<input type=button onclick="setupWords()" value="Setup">  <!-- Button that will call setupWords() when clicked -->
</div>
<!-- div that will be hidden except when the mouse is over a word in the text -->
<br/>
<div id="div2">The current word is: <strong><span id="wddiv"></span></strong> at position <span id="posdiv"></span>.<br/> Definition: <em id='definition'></em></div>

<script>

function simpleQuery(queryUrl)
{
    $.ajax({
        type: 'GET',
        url: queryUrl,
        success: response => setDefinitionFromDictionaryResponse(response),
        failure: error    => console.log(error)
    });
}

function setDefinitionFromDictionaryResponse(response)
{
  let first_definition = response[0].meanings[0].definitions[0].definition
  $("#definition").html(first_definition);
}

function setupWords()
{
    let wordsArray = $("#wordarea").val().split(" ");
    let words = "";

    for (let i = 0; i < wordsArray.length; i++)
    {
        wordsArray[i] = "<span class='word' id='wd" + i + "'>" + wordsArray[i] + "</span>";
        words = words + wordsArray[i] + " ";
    }

    console.log("words is ", words);

    $("#maindiv").html(words);

    setupjQ();
}

function setupjQ()
{
    $(".word").mouseenter(function ()
    {
        let word = $(this).html().toLowerCase().match(/\b[\w']+\b/g)[0]; // gets word and ignores punctuation
        $(this).css("color", "red");
        $("#wddiv").html(word);
        $("#posdiv").html($(this).attr("id").substring(2));
        $("#div2").show();

        let dictionary_url = `https://api.dictionaryapi.dev/api/v2/entries/en/${word}`
        simpleQuery(dictionary_url)
    });

    $(".word").mouseleave(function ()
    {
        $(this).css("color", "blue");
        $("#div2").hide();
    });
}

$(document).ready(function () {
    $("#div2").hide();    // hide div2 element as soon as document is ready (on page load)
});
</script>
And here is the script for this version:

```php
<script>

function simpleQuery(queryUrl)
{
    $.ajax({
        type: 'GET',
        url: queryUrl,
        success: response => setDefinitionFromDictionaryResponse(response),
        failure: error    => console.log(error)
    });
}

function setDefinitionFromDictionaryResponse(response)
{
  let first_definition = response[0].meanings[0].definitions[0].definition
  $("#definition").html(first_definition);
}

function setupWords()
{
    let wordsArray = $("#wordarea").val().split(" ");
    let words = "";

    for (let i = 0; i < wordsArray.length; i++)
    {
        wordsArray[i] = "<span class='word' id='wd" + i + "'>" + wordsArray[i] + "</span>";
        words = words + wordsArray[i] + " ";
    }

    console.log("words is ", words);

    $("#maindiv").html(words);

    setupjQ();
}

function setupjQ()
{
    $(".word").mouseenter(function ()
    {
        let word = $(this).html().toLowerCase().match(/\b[\w']+\b/g)[0]; // gets word and ignores punctuation
        $(this).css("color", "red");
        $("#wddiv").html(word);
        $("#posdiv").html($(this).attr("id").substring(2));
        $("#div2").show();

        let dictionary_url = `https://api.dictionaryapi.dev/api/v2/entries/en/${word}`
        simpleQuery(dictionary_url)
    });

    $(".word").mouseleave(function ()
    {
        $(this).css("color", "blue");
        $("#div2").hide();
    });
}

$(document).ready(function () {
    $("#div2").hide();    // hide div2 element as soon as document is ready (on page load)
});
</script>
```

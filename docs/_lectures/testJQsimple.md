---
layout: page
title: Testing JQuery
author: "John Lee"
order: 7
week: 3
---

A silly example that displays some text such that the mouse running over the text causes words to change colour and displays in another div the current word and its position in the text. Styling is minimal.

<div id="maindiv">
<!-- Textarea containing arbitrary text; the user can paste something else into this textarea if they want -->
<textarea rows="10" cols="70" id="wordarea">
Of course, two SOMs connected in this fashion can learn no more or less than a single SOM would. But the stratification of the SOMs allows for processing to occur at intermediate stages. There are three types of intermediate processing that are relevant to the present discussion: activation decay, activation blurring, and multi-modal layers. Activation decay allows the activation of a given node to decay over time, rather than reset at each time step.
</textarea>
<br />
<input type=button onclick="setupWords()" value="Setup">  <!-- Button that will call setupWords() when clicked -->
</div>
<!-- div that will be hidden except when the mouse is over a word in the text -->
<div id="div2">The current word is: <span id="wddiv"></span> at position <span id="posdiv"></span></div>

<script>

function setupWords() {
    let words = $("#wordarea").val();  // Gets the value (text content) of the textarea

    // Here we split the string of words up into an array of individual words
    let wordsArray = words.split(" ");

    // Throw away the words, because we're going to rebuild this string with some added HTML
    words = "";

    // Loop through the array of words ...
    for (let i = 0; i < wordsArray.length; i++) {
        // put span tag around each word, including a unique id and class 'word'
        wordsArray[i] = "<span class='word' id='wd" + i + "'>" + wordsArray[i] + "</span>";
        // and now stick these back together into a single string again
        words = words + wordsArray[i] + " ";
    }

    // Show the resulting HTML string on the error console, just as a diagnostic
    console.log("words is ", words);


    // Note this is exactly equivalent to:  document.getElementById("maindiv").innerHTML=words;
    $("#maindiv").html(words);

    setupjQ();
}

function setupjQ() {
    $(".word").mouseenter(function () {  // what to do if the mouse enters one of the span elements (class is word)
        $(this).css("color", "red");    // turn this element, that the mouse has entered, red
        $("#wddiv").html($(this).html());  // put the innerHTML of this element (a word) into wddiv
        // Get the id attribute of this element (e.g. "wd27"), take off the first two characters ("wd"),
        // then put the remainder (e.g. "27") into the innerHTML of posdiv
        $("#posdiv").html($(this).attr("id").substring(2));
        $("#div2").show();    // show div2 element
    });

    $(".word").mouseleave(function () {  // what to do when the mouse leaves the span element
        $(this).css("color", "blue");
        $("#div2").hide();
    });
}

$(document).ready(function () {
    $("#div2").hide();    // hide div2 element as soon as document is ready (on page load)
});

</script>

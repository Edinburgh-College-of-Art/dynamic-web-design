---
title: Wee JavaScript Examples
---

(view page source to see the functions being called from the links)

-  <a href="#" onclick="shout('Hello world')">An alert.</a>
-  <a href="#" onclick="hide(); return false;" id="begone">Hide me.</a>
-  <a id="alphafade" href="#" onclick="fade(); return false;">Fade this.</a>
-  <a href="#" onclick="fadethat('alphafade'); return false;" id="checker">Change that.</a>
-  <a href="#" onclick="getRandom()">Random number</a>

[<< Back to DOM](the-dom.html)

<script type="text/javascript">

//alert function
function shout(message)
{
  alert(message);
}

//sets the
function hide()
{
  var hidethis = document.getElementById("begone");
  var style = "display: none;";
  hidethis.setAttribute("style", style);
  alert("I am hiding");
}

var opacity = 1.0;

function fade()
{
  t = setTimeout("fade()", 100);
  opacity -= 0.1;

  var fadethis = document.getElementById("alphafade");

  if (opacity <= 0.05)
  {
    opacity = -0.1;
    fadethis.setAttribute("style", style);
    clearTimeout(t);
  }

  var style = "filter:alpha(opacity=" + (opacity * 100) + "); -moz-opacity:" + opacity + "; opacity: " + opacity + ";";
  fadethis.setAttribute("style", style);
}

function fadethat(targetobj)
{
  var readthis = document.getElementById(targetobj);
  readthis.setAttribute("style", "filter:alpha(opacity=40); -moz-opacity:0.4; opacity:0.4;");
}

function getRandom()
{
  var myRand = Math.floor(Math.random() * 100);
  alert(myRand);
}

function create(targetobj)
{

  var readthis = document.getElementById(targetobj);
  var newpara = document.createElement("div");
  readthis.appendChild(newpara);

  var parentstyle = document.getElementById("dom");

  newpara.setAttribute("style", "background-color:#112233; width: 100px; height: 100px; float: left; margin: 10px;");

  newpara.setAttribute("onclick", "fadethis(this)");

  //alert(newpara.getAttribute("style"));
}


function fadethis(targetobj)
{
  resetopacity();
  fade();
  alert(opacity);
  t = setTimeout("fadethis(targetobj)", 100);
  opacity -= 0.1;

  if (opacity <= 0.05)
  {
    opacity = -0.1;
    targetobj.setAttribute("style", style);
    clearTimeout(t);
  }

  var style = "filter:alpha(opacity=" + (opacity * 100) + "); -moz-opacity:" + opacity + "; opacity: " + opacity + ";";
  targetobj.setAttribute("style", style);
}
</script>

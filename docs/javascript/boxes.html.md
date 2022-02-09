---
title: Make Shapes
---

<script type="text/javascript">

  let size = 100;
  let opacity = 1;

  function create(targetobj, togglerandom){
  let readthis = document.getElementById(targetobj);
  let newbox = document.createElement("div");
  readthis.appendChild(newbox);

  let parentstyle = document.getElementById("dom");

  randColor();
  if(togglerandom){
  let sizer = Math.floor(Math.random() *100);
  }
  else{
  let sizer = 100;
  }

  let style = "background-color:rgb("+newcolor+"); width:"+sizer+"px; height: 100px; float: left; margin: 10px;";
  newbox.setAttribute("style", style);
  newbox.setAttribute("onclick", "fadethis(this)");
  newbox.setAttribute("onmouseover", "newColor(this)");
  }

  function randColor(){
  let red = Math.floor(Math.random() * 255);
  		let green = Math.floor(Math.random() * 255);
  		let blue = Math.floor(Math.random() * 255);
  newcolor = red+','+green+','+blue;
  return(newcolor);
  }

  function newColor(target){
  randColor();
  currentstyle = target.getAttribute("style");
  target.style.backgroundColor="rgb("+newcolor+");";
  }

  function fade(targetobj){
  t=setTimeout("fade('" + targetobj + "')", 1000);
  opacity -= 0.1;
  if(opacity <= 0.05){
  opacity = -0.1;
  targetobj.setAttribute("style", style);
  clearTimeout(t);
  alert("gone");
  opacity = 1;
  }
  //alert(targetobj.style.backgroundColor);
  currentstyle = targetobj.getAttribute("style");
  let style = currentstyle +"filter:alpha(opacity="+(opacity*100)+"); -moz-opacity:"+opacity+"; opacity: "+opacity+";";
  targetobj.setAttribute("style", style);
  }

  function resetopacity(){
  opacity = 1.0;
  }

  function fadethis(currentcube){
  /*alert(currentcube);
  resetopacity();

  fade(currentcube);*/
  currentcube.setAttribute("style", "");
  }
</script>

<style>
#dom{
  float: left;
}

#dom a{
  color: #333333;
}

#dom ul{
  padding-left: 0px;
}
#dom li{
  display: block;
  float: left;
  margin-right: 10px;
}

.clear{
  clear:both;
}
</style>


-  <a href="#" onclick="create('dom', false); return false;">Square</a>
-  <a href="#" onclick="create('dom', true); return false;">Random Rectangle</a>
-  <a href="">Clear all</a>
<br/>
<div id="dom">
</div>
<br/>

<br/>
[<< Back to DOM](the-dom.html)

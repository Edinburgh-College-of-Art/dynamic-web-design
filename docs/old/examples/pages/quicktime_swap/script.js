// JavaScript Document
/*---------------------------------------------- Gallery --------------------------------*/
/*-------------  Script based on tutrial by Jeremy Keith in, DOM Scripting: Web Design with JavaScript and the Document Object Model ------*/
/*-------------  Script has been minorly altered to suit the needs of this project --------------------------------------------------------*/

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}

function insertAfter(newElement,targetElement) {
  var parent = targetElement.parentNode;
  if (parent.lastChild == targetElement) {
    parent.appendChild(newElement);
  } else {
    parent.insertBefore(newElement,targetElement.nextSibling);
  }
}

function preparePlaceholder() {
  if (!document.createElement) return false;
  if (!document.createTextNode) return false;
  if (!document.getElementById) return false;
  if (!document.getElementById("imagegallery")) return false;
  var gallerydisplay = document.createElement("div");
  gallerydisplay.setAttribute("id","gallerydisplay");
  gallerydisplay.appendChild(makePlaceHolder("jr_bayeuxmovie.mp4"));  
  var gallery = document.getElementById("imagegallery");
  insertAfter(gallerydisplay,gallery);
}

function prepareGallery() {
  if (!document.getElementsByTagName) return false;
  if (!document.getElementById) return false;
  if (!document.getElementById("imagegallery")) return false;
  var gallery = document.getElementById("imagegallery");
  var links = gallery.getElementsByTagName("a");
  for ( var i=0; i < links.length; i++) {
    links[i].onclick = function() {
      return showPic(this);
	}
    links[i].onkeypress = links[i].onclick;
  }
}

function showPic(whichpic) {
  if (!document.getElementById("placeholder")) return true;
  var source = whichpic.getAttribute("href");
  document.getElementById("gallerydisplay").removeChild(document.getElementById("placeholder"));
  document.getElementById("gallerydisplay").appendChild(makePlaceHolder(source));
  return false;
}

function makePlaceHolder(source){
  var placeholder = document.createElement("object");
  placeholder.setAttribute("id","placeholder");
  placeholder.setAttribute("type", "video/quicktime");
  placeholder.setAttribute("data",source);
  placeholder.setAttribute("width", "320");
  placeholder.setAttribute("height", "260");
  return placeholder;
 }

addLoadEvent(preparePlaceholder);
addLoadEvent(prepareGallery);

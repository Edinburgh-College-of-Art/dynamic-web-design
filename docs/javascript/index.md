---
title: Javascript Basics
---

The best reference and place to keep abreast of best practice with JavaScript is the [MDN Documentation](https://developer.mozilla.org/en-US/docs/Web/javascript). JavaScript is a constantly evolving language. As a result, you should be careful when copying code snippets and pay careful attention to the date a page was authored.

We can write javascript into an HTML document by using the `<script>` tag. Generally, we'll try and keep all of our javascript in the header of the document. Ideally, we'd keep the script out of the document all together by creating a new javascript document for it, and then linking that document to the HTML page in the header:

```html
<script type="text/javascript" language="javascript" src="scripts/ascript.js"></script>
```

## Events

Events are the things happening to an object: a click, the mouse moving over it, etc. Typically, we use events to call a function. We can put some javascript on an object receiving the events to call a function when they happen. This means putting some javascript into the body of your HTML code, which generally we will try and avoid doing.

## Alerts

'Alerts' are those message boxes which your browser uses to communicate with you. Generally, they're kind of annoying as they halt the progress of the page and wait for the user to click 'ok'. When writing a javascript, however, alerts are a great way of telling up what's going on.

## Functions

Functions are the building blocks of code that you'll write to carry out particular tasks.

```js
function myfunction()
{
  alert("Hello world.");
}
```

We could call this function from a link by adding an `'onclick'` attribute to it:

```html
<a href="#" onclick="myfunction()">click for alert</a>
```

Which would do this: <a href="#" onclick="myfunction()">click for alert</a>

We're going to look at how to use javascript in conjunction with the document object model (DOM) and CSS to make some dynamic bits of HtML.

## References:

-   [MDN](https://developer.mozilla.org/en-US/docs/Web/javascript)
-   [W3Schools,](http://www.w3schools.com/js/default.asp)
-   [HowToCreate javascript
    tutorial,](http://www.howtocreate.co.uk/tutorials/javascript/)
-   [The web developer's field
    guide,](http://webdevelopersfieldguide.com/)

## Suggested Libraries:

-   [P5.js](https://p5js.org): is buckets of fun, and a good interface for [WebAudio](https://developer.mozilla.org/en-US/docs/Web/API/Web_Audio_API)
-   [Threejs](https://threejs.org): For 3D models and environments
-   [BokehJs](https://docs.bokeh.org/en/latest/docs/dev_guide/bokehjs.html): For data visualisation
-   [Leaflet](https://leafletjs.com): For maps

**Next:** [The DOM >>](the-dom.html)

<script type="text/javascript">
  function myfunction(){
    alert("Hello world.");
  }
</script>

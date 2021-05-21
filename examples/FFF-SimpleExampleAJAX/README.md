# FFF-SimpleExampleAJAX

This example build upon the last two examples.

This example will demonstrate how to perform AJAX queries, in particular using the jquery library

## Setup

No setup is required, but you will need to have implemented the `ImageServer` and `SimpleExample`

## Examples

The list of examples included are

- [/simple_ajax](simple_ajax)
- [/random](random)
- [/hint](hint)

### Simple Ajax

This is the most basic an AJAX query can get. 

Enter a URL and click the button. The response will then be printed below. Try the `infoservice` of the image server. 

This is how you can start interacting with APIs.

### Random

The random example will pull a random thumbnail from your ImageServer database. 
This demonstrates how you can use data from an AJAX query to make your site dynamic.

### Hint

Hint shows how you can interact with your own database. It looks a little basic, but it ties together all parts of the MVC design pattern.

## Structure

There is an additional `js/` diretcory in your `ui/` directory. This would be agood place to store your JavaScript files.

There is also now a `head.html` file. You can collect together all the `<script>` and `<link>` tags that appear in your `<head>` tag
This should help to keep your `layout` in order, but also make it easier to manage any additional libraries.


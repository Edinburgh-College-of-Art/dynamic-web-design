---
layout: home
title: Dynamic Web Design
---

## Help Pages

See these pages for simple step-by-step instructions on how to setup for Dynamic Web Design:

{% assign setup_by_order = site.setup | sort: "order" %}
{% for setup in setup_by_order | sort: "order" %}
{{setup.order}}. [{{ setup.title }}](<{{setup.url | prepend:site.baseurl }}>)
{% endfor %}


## Example Projects Downloads

Use the following projects as the template for your own work.

- [Simple Example](https://github.com/Edinburgh-College-of-Art/dynamic-web-design/releases/download/0.1.0/FFF-SimpleExample.zip)
- [Image Server](https://github.com/Edinburgh-College-of-Art/dynamic-web-design/releases/download/0.1.0/FFF-ImageServer.zip)
- [AJAX Queries](https://github.com/Edinburgh-College-of-Art/dynamic-web-design/releases/download/0.1.0/FFF-SimpleExampleAJAX.zip)

## Lecture Notes

{% assign lecture_by_order = site.lectures | sort: "order" %}
{% assign week = 0 %}
{% for lecture in lecture_by_order %}
{% if lecture.week != week %}
{% assign week = lecture.week %}
###  Week {{week}}
{% endif %}
 - [{{ lecture.title }}](<{{lecture.url | prepend:site.baseurl }}>)
{% endfor %}

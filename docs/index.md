---
layout: home
title: Dynamic Web Design
---

A repository for things related to the Dynamic Web Design Course.
Currently just:

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

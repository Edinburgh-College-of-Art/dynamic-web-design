---
layout: home
title: Dynamic Web Design
---

A repository for things related to the Dynamic Web Design Course.
Currently just:


## Lecture Notes
{% for lecture in site.lectures %}
- [{{ lecture.title }}]({{lecture.url}})
{% endfor %}

---
layout: page
title: Original DWD Files
---

<ul>
{% for file in site.static_files %}
<!-- {% assign filename = lecture.path | last %} -->
{% assign filetype = file.path | split: "." | last  %}

{% if filetype  == "html" %}
{% assign path_depth = file.path | split: "/" | size | minus: 2 %}
  <li>
  {{file.path | split: "/" | slice: 1, path_depth| join: '/' }}<a href="{{file.path | prepend: site.baseurl}}">/{{file.name | split: "." | first}}</a>
  </li>
{% endif %}
{% endfor %}
</ul>

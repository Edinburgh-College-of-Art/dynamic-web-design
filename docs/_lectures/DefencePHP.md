---
layout: page
title: Yet More PHP
author: "John Lee"
---

## Defensive programming

"Defensive programming" is about defending yourself against problems
by anticipating them and arranging things so that they are handled
elegantly (or at least, reasonably neatly).

PHP provides a good mechanism for doing this, with its _catch()_
construction. Many programming languages (e.g. ActionScript and Java)
have the idea of an _exception_, which means some sort of unwanted
condition. An error will often _throw_ an exception; if one can _catch_
the exception, one can _handle_ it in some reasonable way.

The _catch()_ construction works within a context that is set up by
using _try_. Here is an earlier example set up to catch the undefined
variable exception using _catch()_
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/urltest-catch.cfm?message1=MESSAGE&>):

```php
[try {
    echo "The first message given on the URL was <font
color=red>".$_GET["message1"]]{.style2}[."</font> ...n";
<br />
"The second message given on the URL was <font
color=red>".$\_GET["message2"]."</font> ...n";
/CFOUTPUT>
]{.style2}[}
catch(Exception $e){
    echo "<p>**** I'm afraid you have some kind of error:
".$e->getMessage()."</p>";
}]{.style2}
```
In PHP documentation (and books) there are examples of how to use
catch() to handle specific errors (that throw exceptions) from
databases. Here's a simple example of using it to handle the situation
when a database is unavailable, which usually happens when the database
server is down, even though the ColdFusion server is OK.

Here is a somewhat defensively coded database update query:
```xml
<CFTRY>
<CFLOCK NAME="InsertNewRecord" TYPE="EXCLUSIVE" TIMEOUT="30">
<CFTRANSACTION>
<CFQUERY NAME="TcktRequest" DATASOURCE="ddmtest">
INSERT INTO justanexample(email, name, number)
VALUES ('#Form.email#', '#Form.name#', '#Form.number#')
</CFQUERY>
</CFTRANSACTION>
</CFLOCK>
<CFCATCH type="Database">
<h3>Error: Unfortunately the database connection has failed. <br>
Probably the database server is down: please try again later. </h3>
<p>If problems persist, please contact <a
href="mailto:J.Lee@ed.ac.uk">John Lee</a>.<br> Thanks.</p>
<CFABORT>
</CFCATCH>
</CFTRY>
```

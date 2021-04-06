---
layout: page
title: Using a server for Dynamic Web Design
author: "John Lee"
---

# More ColdFusion

## Conditional processing

Conditional processing in ColdFusion templates means having some part of
the template that will produce different output depending on a condiion
such as the value of some variable.

We have seen this already in the example of the simple "currency
converter", as *a form that gets posted to itself* .

Here's another example, making use of the fact that variables provided
to the template in a query string as part of the URL are also made very
simply and directly available to the template as members of an object
called *URL*. Look at this
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/urltest.cfm?message1=MESSAGE&message2=MESSAGE>):

<CFOUTPUT>
The first message given on the URL was <font
color=red>#URL.message1#</font> ...
<br />
The second message was <font color=red>#URL.message2#</font>
</CFOUTPUT>

Notice there's a problem here if either message is missing: we get an
unpleasant error output. One way to fix this is to have some
conditionals, such as
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/urltest2.cfm?message1=MESSAGE&>):

<CFOUTPUT>
The first message given on the URL was
<CFIF IsDefined('URL.message1')>
<font color=red>#URL.message1#</font> ...
<CFELSE>
not specified!
</CFIF>
<br />
The second message was
<CFIF IsDefined('URL.message2')>
<font color="red">#URL.message2#</font> ...
<CFELSE>
not specified!
</CFIF>
</CFOUTPUT>

## Default parameters

Another useful feature of CF that we could use in this case is the
CFPARAM tag, which sets a named parameter with a default value. The
value of this is that the parameter is then used in any context (where
it is accessible) if an object member of the same name would normally be
used in that context but is undefined. This means, in particular, that
you can set a parameter with a value that will be used if the expected
member of the URL (or Form) object is undefined. Look at this
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/urltest3.cfm>):


[<CFPARAM NAME="message1" DEFAULT="not specified!">
<CFPARAM NAME="message2" DEFAULT="not specified!">]{.style2}

<CFOUTPUT>
The first message given on the URL was
<font color=red>#message1#</font> ...
<br />
The second message was
<font color="red">#message2#</font> ...
</CFOUTPUT>

Now here, if we don't specify anything for one of these messages on the
URL, the default will be used. On the other hand, if we do, then in this
context ColdFusion will assume that we wanted to use the URL object, and
so it will use the URL values. See e.g.
[http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/urltest3.cfm?message2="MESSAGE2"](http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/urltest3.cfm?message2=MESSAGE2).

We could apply this idea to elaborate the currency converter to avoid
the probem of "not a number" errors if nothing is entered (original
version at <http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/convert.cfm>; new
version at <http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/convert2.cfm>):


[<cfparam name="Source" default="0.00">
<cfparam name="Rate" default="1.00">
]{.style2}[
<form name="form1" method="post" action="convert2.cfm">
<cfoutput>
<p> Source currency:
<input type="text" name="Source" value="#Source#">
</p>
<p> Conversion rate:
<input type="text" name="Rate" value="#Rate#">
</p>
<p>
<input type="submit" name="Submit" value="Submit">
</p>
</cfoutput>
</form>]{.style2}

<CFIF IsDefined('Form.Submit')>
<CFSET Result=Form.Source*Form.Rate >
<CFOUTPUT>
<h2>The result is: #Result# in the target currency.</h2>
</CFOUTPUT>
</CFIF>

Now we never have the form appearing with empy boxes in the first place.
However, this will not be enough to stop the problem arising if the user
deletes the value in a box, or types in text, etc. We could develop the
code further using the *IsNumeric* function that tests whether a value
is (convertible to) a number or not -- see
<http://livedocs.adobe.com/coldfusion/8/htmldocs/help.html?content=functions_in-k_24.html>,
which describes the example at
<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/isNumericExample.cfm>.

Further insight into the operation of forms, parameters and various
objects can be got from looking at a version of this converter that uses
separate form and processing templates. Consider
<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/convertform.cfm> -- here,
the template just presents the form, with some default values already in
it:

<cfparam name="Source" default="0.00">
<cfparam name="Rate" default="1.00">[

<form name="form1" method="post" action="convertproc.cfm">
<cfoutput>
<p> Source currency:
<input type="text" name="Source" value="#Source#">
</p>
<p> Conversion rate:
<input type="text" name="Rate" value="#Rate#">
</p>
<p>
<input type="submit" name="Submit" value="Submit">
</p>
</cfoutput>
</form>]{.style2}

-- the processing being done by *convertproc.cfm* (which should never
be called directly):

[<CFSET Result=Form.Source*Form.Rate >
<CFOUTPUT>
<h2>The result is: #Result# in the target currency.</h2>
[
]{.style9}]{.style2}[<a
href="convertform.cfm?Source=#Form.Source#&Rate=#Form.Rate#">Return
to form ...</a>]{.style8}[
</CFOUTPUT>
]{.style2}
This is just what was inside the CFIF tags in the previous version,
except that we have added the line highlighted in red, which passes back
the new values to the form *on the URL*. Now, when the form template is
called, it uses the parameter values from the URL rather than the
CFPARAM defaults.

## Checkboxes

Another useful context for CFPARAM is where you are using checkboxes on
a form. These can be confusing because if the box is not checked on the
form, then the corresponding Form variable is *undefined*, so if you try
to use it you will get an error.

Consider this situation
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/cfboxtest.cfm>):

<form id="form1" name="form1" method="post"
action="cfboxtest.cfm">
<p>Check box:
<input type="checkbox" name="checkIt" id="checkbox" />
</p>
<p>
<input type="submit" name="Submit" id="button" value="Update"
/>
</p>
</form>
<p>
<cfif IsDefined('Form.Submit')>
<cfoutput>
Value of checkbox is #checkIt# ...
</cfoutput>
</cfif>

Here, you'll find that if the box is checked, the value is "on", but
if it isn't an error results. This is very bad. The simplest way to fix
this would be to put the following line in somewhere before the test:

<CFPARAM name="CheckIt" default="off">

(or use whatever other default value you like) then the problem is
resolved fairly elegantly
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/cfboxtest-p.cfm>).

Better still, we can use a test for whether the value is "on" at the
point where the box is created on the form, and if so have it checked
already when it appears. In this way, the state of the box remains as
the user tends to expect
(<http://webdbdev.ucs.ed.ac.uk/ddm/1011/test/cfboxtest-c.cfm>):

<cfparam name="checkIt" default="off">

<form id="form1" name="form1" method="post"
action="cfboxtest-c.cfm">
<p>Check box:
<input type="checkbox" name="checkIt" id="checkbox"
<cfif checkIt is "on">
checked
</cfif>
/>
</p>
<p>
<input type="submit" name="Submit" id="button" value="Update"
/>
</p>
</form>
<p>
<cfif IsDefined('Form.Submit')>
<cfoutput>
Value of checkbox is #checkIt# ...
</cfoutput>
</cfif>

Notice that if you want "on" to be something else, say "set", then
you can add *value="set"* as a parameter to the input of type
checkbox, and then you can use "set" (or whatever you chose as the
value) instead of "on" everywhere in your code. This is likely to keep
things clearer if you have a number of checkboxes on the same form.

 



 

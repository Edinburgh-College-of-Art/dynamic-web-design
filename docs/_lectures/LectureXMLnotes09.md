---
layout: page
title: "Distinguishing Form and Substance: HTML and XML"
author: "John Lee"
---

- [Introduction to Design and Digital Media](#introduction-to-design-and-digital-media)
- [**HTML**](#html)
- [XML](#xml)
- [REQUIRED>](#required) - [XML for data exchange](#xml-for-data-exchange)
- [XML processing with ColdFusion](#xml-processing-with-coldfusion)
- [Why is XML really becoming such a buzzword?](#why-is-xml-really-becoming-such-a-buzzword)
- [Sources and resources](#sources-and-resources)

## Introduction to Design and Digital Media

The focus of this lecture is on information, how to present it through
the Web, and also how to package and transmit it between applications..

When we think about presenting information, it seems intuitively
plausible that we can draw a distinction between _what_[ the information
is that 's being presented, and on the other hand
]{style="font-style:normal"}_how_[ it's being presented. Another way of
thinking of this is that we can distinguish the substance or content of
the information from the form in which it's expressed. These intuitions
are the basis of many of the approaches to information presentation on
the World Wide Web, and in particular of the rapidly expanding use of
XML. In this lecture, we look at a few of the basic techniques available
in this area.]{style="font-style:normal"}

## **HTML**

HTML (the "HyperText Markup Language") is historically part of a
sustained effort to develop a way of describing the form of documents
("marking them up") in a way that would be standardised and facilitate
their exchange between people and computer systems.

Researchers tried a considerable range of approaches, often based
initially on traditional concepts such as "title", "section",
"subsection", "paragraph", etc. It was realised that a good deal of
flexibility was going to be required to cover the huge range of existing
and possible future types of document. This resulted in a very general
solution: the Standard General Markup Language (SGML). Modern markup
languages like HTML are ultimately derived from this.

In some sense, HTML has the effect of treating a document as a kind of
data. It contains specific tags that identifiy text features that we
usually see as fairly intuitive: headings, paragraphs, lists, tables,
etc. These are aspects of the _structure_ of the document, that are
somewhat independent from the content in it.We are already used to the
idea that the way these things appear (are formatted) can change, and
can be controlled via Cascading Style Sheets (CSS). CSS allows us to
define styling information for specific tags, and include this with the
"vanilla" HTML so that the way these tags are interpreted is changed
globally.

So the data (the text) is structured and presented through a system that
marks it up and allows us to specify what kinds of things it contains
and how we want to see them displayed.

## XML

A problem with HTML, even with this elaborated styling mechanism, is
that the objective of the markup is to control the _appearance_[ of a
document, the way text is laid out and presented, not the structure of
the *information* (the content) that it contains, which is whatever the
text is *about*. ]{style="font-style:normal"}

[But often, the latter is much more useful. If we can mark up the
content and then as a completely separate step define different ways for
this to appear, we will have a much more flexible system.
]{style="font-style:normal"}

[The ]{style="font-style:normal"}_Extensible Markup Language_[ (XML) is
fundamentally a way of defining our own tags, which are meaningful to us
in terms of some particular kind of information we are interested in.
There is then also a system (actually, a number of alternative systems)
that will let us transform these tags into normal HTML as understood by
browsers, so that we can present the information however we want (if we
want to present it at all]{style="font-style:normal"} -- as we'll see,
XML is intended for many other purposes than this).

XML can be used to define documents of endless varieties, as a sort of
elaborated form of HTML, including special kinds of paragraphs, lists
etc. HTML itself is now defined by the W3C in terms of XML, and very
often the two are closely integrated.

XHTML, as commonly used with CSS, is really an extended set of HTML
tags, defined using XML, which allows a more refined control of
appearance without altering the content.

Systems that work with HTML that isn't expected to be human-readable
often get very complicated about the integration. As an example of this,
the following comes from the source of an old version of these notes,
which is HTML produced from MS Word:

```html
<html
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office"
  xmlns:w="urn:schemas-microsoft-com:office:word"
  xmlns="http://www.w3.org/TR/REC-html40"
>
  <head>
    <meta
      name="Title"
      content="Distinguishing Form and Substance: HTML and
XML"
    />
    <meta name="Keywords" content="" />
    <meta
      http-equiv="Content-Type"
      content="text/html;
charset=windows-1252"
    />
    <meta name="ProgId" content="Word.Document" />
    <meta name="Generator" content="Microsoft Word 10" />
    <meta name="Originator" content="Microsoft Word 10" />
    <link rel="File-List" href="Lecture3notes_files/filelist.xml" />
    <link rel="Edit-Time-Data" href="Lecture3notes_files/editdata.mso" />
    <!--[if !mso]>
      <style>
        v:* {
          behavior: url(#default#VML);
        }
        o:* {
          behavior: url(#default#VML);
        }
        w:* {
          behavior: url(#default#VML);
        }
        .shape {
          behavior: url(#default#VML);
        }
      </style>
    <![endif]-->
    <title>Distinguishing Form and Substance: HTML and XML</title>
    <!--[if gte mso 9]><xml>
<o:DocumentProperties>
<o:Author>John Lee</o:Author>
<o:Template>Normal</o:Template>
<o:LastAuthor>John Lee</o:LastAuthor>
<o:Revision>2</o:Revision>
<o:Created>2004-01-20T10:56:00Z</o:Created>
<o:LastSaved>2004-01-20T10:56:00Z</o:LastSaved>
<o:Pages>32</o:Pages>
<o:Words>3711</o:Words>
<o:Characters>21158</o:Characters>
<o:Company>University of Edinburgh</o:Company>
<o:Lines>176</o:Lines>-->
  </head>
</html>
```

-- the complexity of this HTML and the amount of embedded XML
information is very striking! Most of the material is _metadata_ about
the nature of the matrerial in the document, which is something else
we'll come back to.

We will not be looking any further at text document markup here, but
will focus more on the use of XML for marking up _general data_[ that
may be about any kind of items. We want to be able to identify the items
and their attributes before we consider any issues about how to process
or present this data, and this is where XML turns out to be
ideal.]{style="font-style:
normal"}

Suppose we have some information about a collection of building
products, similar to the ones considered in the ColdFusion examples
earlier. The following is a possible way to mark this up.

```xml
<productDB>
<product>
<manuf URL="http://www.wilkins.com">Wilkins doors</manuf>
<name type="door">Superdoor</name>
<description>Excellent sound insulation properties. 
Lightweight.</description>
<price>87.43</price>
</product>
<product>
<manuf URL="http://www.fenester.com">Fenester plc</manuf>
<name type="window">Ultra Sash</name>
<description>Double glazed.  Smooth action.</description>
<price>123.41</price>
</product>
<product>
<manuf>Lights Unlimited</manuf>
<name type="lighting">Track spot 43</name>
<price>21.99</price>
</product>
</productDB>
```

This is a database of products ([productDB]{.codejl}), containing at
present only 3 items ([product]{.codejl}), about each of which we have
information such as the manufacturer ([manuf]{.codejl}), name of the
product, a description and a price. In addition, some of these tags have
_attributes_[: the manufacturer has (optionally) a URL, and the name has
a type. ]{style="font-style:normal"}

[It is entirely up to us how we organise these things. We can have other
tags, and we can have whatever attributes we like. (The structure here
isn't necessarily a good structure, of course  it's just for the sake
of an example.) ]{style="font-style:normal"}

[It would be good to make sure that we use these things consistently,
however, and especially if the database gets at all large then it would
be nice to have this consistency checked automatically.
]{style="font-style:normal"}

[With XML, that's easy, because we can create a Document Type
Definition (DTD). The DTD simply defines a set of tags and attributes,
and says how they can be used. ]{style="font-style:normal"}

[Whenever an XML file is read, it will be
]{style="font-style:normal"}_parsed_[, and if the parser is a
]{style="font-style:
normal"}_validating parser_[ it will check against the DTD so see if the
tags are used as the DTD says.  If they are not, an XML error message
will be generated.  Here's a DTD for the XML above
([products-bare.xml](products-bare.xml)).]{style="font-style:normal"}

```html
<!DOCTYPE productDB [ <!ELEMENT productDB (product)*>
<!ELEMENT product (manuf,name,description?,price?) >
<!ELEMENT manuf (#PCDATA) >
<!ATTLIST manuf URL NMTOKEN #IMPLIED>
<!ELEMENT name (#PCDATA) >
<!ATTLIST name type (door|window|flooring|lighting|furniture)
#REQUIRED>
<!ELEMENT description (#PCDATA) >
<!ELEMENT price (#PCDATA) >

]>
```

This looks more complicated than it really is (!). All it says is that a
productDB consists of an arbitrary number of products, each of which has
a manufacturer and a name, and _optionally_ a description and a price.
The manufacturer may have a URL attribute, and the name must have a
type, which has to be one of the things listed. Nothing much is said
about what can be entered as the description or price (they're just
"parsed character data"  PCDATA), but further requirements could be
placed on these if we wanted. However, simple though it is, this already
specifies quite usefully the structure of what can count as part of our
product database.

Now we want to display (or _style_[) the data. One possibility is simply
to use CSS again. CSS will allow us to define styles for any tags, so we
could have, e.g.:]{style="font-style:normal"}
```
productDB{ display: block;
margin-left: 10%; margin-right: 10%;
background-color: rgb(150, 150, 256);
font-size: 18pt; font-weight: bold;
font-family: arial, helvetica, sans-serif;
}
product{ display:  block;
font-size: 80%; color: blue
}
manuf{ display:block;
font-size: 80%; font-style: italic; color: red
}
description{ display:block;
font-size:70%; color:green
}
price{
font-size:75%; color:yellow
}
```
 and include this CSS specification at the head of our XML file, which
we then use as if it were HTML. This produces the following (see
[products2.css](products2.css) and [products2c.xml](products2c.xml)):

![](CSS-result.png){width="519" height="286"}

 which is not ideal, since we have rather little control over e.g. the
order in which things appear, and the attributes have been ignored.

A better option is to use XSL, which is a system specifically developed
for styling XML files. XSL is quite complicated in general, and embeds a
powerful programming language which can define elaborate presentations.
However, for practical purposes it can be used relatively simply.

XSL is processed by a system known as XSLT, versions of which are
conveniently implemented in most modern browsers (though there are also
many XSLT implementations that can be used at the server side, e.g. in
ColdFusion  see discussion later).

XSLT can be given XSL stylesheets _to transform any XML structure into
any other_[. Since HTML is also an XML structure, XSLT will take this
XSL stylesheet and use it to transform the original XML into an HTML
output. ]{style="font-style:normal"}

[Here](http://www.w3schools.com/xsl/xsl_transformation.asp) is a simple
example from an external website.

Despite the power, broad cross-platform support, and relative ease of
use of browser-based XML styling, it still does not seem to be widely
exploited in user-directed systems. This will perhaps change in the
future.

## XML for data exchange

[The major value of XML is as an exchange format for transmitting data
across networks, and its value arises mainly from its being standard.
XML itself is not remarkable, but there are a remarkable array of tools
and software systems now available for processing it and making use of
it. ]{style="color:black"}

[Database systems driving web sites directly often do not use XML (as we
have seen with ColdFusion), because it can be quite inefficient to
process in comparison with other representations of the same data. But
if we have to interface with data stored in different formats, e.g. text
files, or if substantial amounts of data have to be transferred
somewhere else, XML is an excellent choice.]{style="color:black"}

[For this reason, most everyday database systems (such as Filemaker Pro,
MySQL, MS Access, etc.) nowadays provide automatic translation to XML.
If the data above is put into Filemaker Pro as a normal data table and
then extracted as XML, one way of doing that produces the following,
which should by now be fairly recognisable
(]{style="color:black"}[products-fp5.xml](products-fp5.xml)[):]{style="color:black"}
```xml
<?xml version="1.0" encoding="UTF-8" ?>

<FMPDSORESULT xmlns="http://www.filemaker.com/fmpdsoresult">

<ERRORCODE>0</ERRORCODE>

<DATABASE>products.fp5</DATABASE>

<LAYOUT>

</LAYOUT>

<ROW MODID="2" RECORDID="1">

<manuf>Wilkins doors</manuf>

<URL>http://www.wilkins.com</URL>

<name>Superdoor</name>

<type>door</type>

<description>Excellent sound insulation properties.</description>

<price>87.43</price>

</ROW>

<ROW MODID="0" RECORDID="2">

<manuf>Fenester plc</manuf>

<URL>http://www.fenester.com</URL>

<name>Ultra Sash</name>

<type>window</type>

<description>Double glazed. Smooth action.</description>

<price>123.41</price>

</ROW>

<ROW MODID="0" RECORDID="3">

<manuf>Lights Unlimited</manuf>

<URL>

</URL>

<name>Track spot 43</name>

<type>lighting</type>

<description>

</description>

<price>21.99</price>

</ROW>

</FMPDSORESULT>
```
Some things to note here are that there are no attributes of the field
tags (which have here been made into separate fields, unlike in our
original form of the example), and that each record has to contain each
field tag, even if there is no data for that field. This is thus a
stricter set of conditions on the XML, which respect the typical
structure of relational databases. Also some general information and the
ROW and FMPDSORESULT tags have been added. Hence, this XML is now well
structured for import into some other suitable database (possibly, as is
provided for in FMP, after further transformations with XSL stylesheets
 it would be easy for instance to transform this XML into the original
XML product data that we had above).

This kind of technique can be used to exchange data between different
databases on different servers, and is potentially very powerful in
conjunction with the ability of many database-oriented systems to
_serialise_[ data. Data serialisation means turning it into a string
which can then be easily communicated across a network.
]{style="font-style:normal"}

[Here, XML comes into its own. A standard format known as WDDX is used
to serialise data from arbitrary databases, and then it can be sent
somewhere else and deserialised before being used directly to update
another database. The WDDX format is somewhat obscure, so I have not
serialised the data above, but it would not be difficult in principle.
]{style="font-style:normal"}You can find a discussion of this in the
O'Reilly ColdFusion book.

## XML processing with ColdFusion

ColdFusion has very advanced features for handling XML data, aside from
the serialisation just mentioned. It can read, parse, create, transform
and style XML in many diverse ways, including applying XSL stylesheets.
This means that in principle if you are doing anything with XML you can
do it at the server side, and not assume anything about the users
browsers ability to style XML at all. (Similar functions are provided
by most other server-side processing systems, such as PHP. ) We'll
mention this again once we've seen the more basic features of
ColdFusion.

There is a good introduction to XML in ColdFusion, though quite terse
and not always easy going (originally from the Macromedia developer
centre), installed at
[http://webdbdev.ucs.ed.ac.uk/ddm/2009/XmlExampleCode/xmlxslt.pdf](http://webdbdev.ucs.ed.ac.uk/ddm/XmlExampleCode/xmlxslt.pdf),
with the code examples discussed in that text being available in the
same directory. As usual, you can copy and paste these into your own
templates elsewhere.

But more important than XSLT applications is the use of XML for broader
web applications, as we will now see.

## Why is XML really becoming such a buzzword?

Probably the best answer to this question is: _Web Services_. Web
services are arbitrary elements of functionality that developers can
make available on the web for use in applications created by other
developers. They are fast becoming a central feature of e-commerce
systems. You can find directories of them, e.g. at
<http://www.xmethods.net/>. These will let you do all kinds of things,
and ColdFusion is a very simple system in which to access them.

Web services generally operate using the Simple Object Access Protocol
(SOAP), which is an XML format. Web services are described using the Web
Services Description Language (WSDL), which is also an XML format.
Another well known case is Really Simple Syndication (RSS): RSS
"feeds" are just XML pages that regularly update, with outline
information in a simple repeating structure. Among many other possible
examples, Amazon.com provides a comprehensive set of web services which
allow other web sites to include Amazon functions, searches,
information, etc. (without it necessarily being obvious that these
services have come from Amazon)  see
<http://www.amazon.com/webservices/>.

This kind of service is already leading towards the web becoming an
integrated network of applications that join relatively seamlessly
together in complex ways that the typical user is entirely unaware of.
Many are free, but also access to web services can be bought and sold;
there are systems for charging, etc. This is a good example of **B2B**
(i.e. business-to-business) e-commerce. Most web services use XML as an
interchange format for the information that forms the basis of the
service. XML is clearly emerging as the standard syntax in which the
billions of communications required for global commerce will be framed
in the coming decades.

## Sources and resources

HTML, XML, XSL and a vast range of other such standards are supervised
by the "World Wide Web Consortium", generally known as _W3C_[. Full
definitions (highly technical) but also pointers to a number of useful
tutorial and other resources can be found at the W3C website:
<http://www.w3c.org/>.  There are also national resource centres, e.g.
the W3C UK site at <http://www.w3c.rl.ac.uk/>  and thousands of other
websites devoted to these topics, which a simple search will immediately
reveal ...]{style="font-style:normal"}

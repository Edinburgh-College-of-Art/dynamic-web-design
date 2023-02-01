---
layout: page
title: "More on APIs: when requests get more complicated ..."
author: "John Lee"
order: 8
week: 4
---
\[Note: the material in this section is old. It's still valid in principle, as far as the technology is concerned, but the example discussed is no longer operational. The way things work with the XML string is the remaining useful point. In other respects, F3 provides a much better way of accessing the API than is used here.\]

APIs can take many different forms. Some of them require no parameters to be supplied, but usually you'll have to specify something, if only a string to search for, etc. Such parameters might be asked for in the form of a query string on the URL, which you can easily construct. Sometimes they are asked for in the form of an XML document that you have to send to the server. An example of this is the Txttools API for retrieving text messages sent to their SMS interface.

Details of the requests are given in their How-To document ([here](XML_Messaging_Connector_for_txttools_2.2.pdf)). We have to construct an XML-formatted string that we send to their server via HTTP POST in a variable called XMLPost. This amounts to exactly the same thing as having a form with a textfield called XMLPost, and putting the XML string into that text field -- but we don't want to create a form and have to click a button, we just want to do this from a PHP script. So we use code like this:

```xml
$XMLrequest='<?xml version="1.0" ?>
<Request>
    <Authentication>
        <Username><![CDATA[jlee@ed]]></Username>
        <Password><![CDATA[PASSWORD-GOES-HERE]]></Password>
    </Authentication>
    <RetrieveInbound>
        <RetrieveType><![CDATA[ALL]]></RetrieveType>
    </RetrieveInbound>
</Request>';

$TXTurl="http://www.txttools.co.uk/connectors/XML/xml.jsp";  // The txttools API URL

$crl = curl_init(); // creating a curl object
$timeout = 10;
curl_setopt ($crl, CURLOPT_URL, $TXTurl);
curl_setopt ($crl, CURLOPT_POST, "TRUE");      // Set curl to use HTTP POST, because by default it uses GET
curl_setopt ($crl, CURLOPT_POSTFIELDS, "XMLPost=".urlencode($XMLrequest)); // Set "form field" XMLPost: NB the XML request is URLencoded!
curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
$xml_to_parse = curl_exec($crl);     // Execute the curl object
curl_close($crl); // closing the curl object
```

This is very like Jules' code using curl, but we adapt it to use HTTP POST. By default, curl uses GET, so we set an option (using curl_setopt) to make CURLOPT_POST be "TRUE". Then we have to tell it what fields we want -- this is just the same as putting fields on a form: in that case, the form will set the varaibles to be whatever is entered on the form, but in this case we will set the variables to be whatever values we need. Here we need only one variable, XMLPost, which we set to be the XML request string -- but note that we urlencode the string first, because otherwise it might get scrambled on the way to the server.

If we needed to supply more field variables, we would build up a query string of the form `Variable1=Value1&variable2=value2&...`: here we just have XMLPost=S, where S is the URLencoded XML string. So then the field variables are all set at once using CURLOPT_POSTFIELDS.

Everything else is the same as in Jules' code earlier.

What comes back is XML with elements that depend on what was requested, as specified in the How-To document. So, as before, we could look at the raw XML by using

```php
    echo $xml_to_parse;
```

and count the elements it contains by using something like

```php
$parsed_xml = simplexml_load_string($xml_to_parse);
$items = $parsed_xml->InboundMessage; // traversing the xml nodes to count how many photos were retrieved

$numOfItems = count($items);
echo "<p>Got $numOfItems " . (($numOfItems == 1) ? "item" : "items") . "</p>n";  // Conditional prints "item" if numOfItems==1, else "items" Then we can access the elements by using code such as

if ($numOfItems > 0) { // yes, some items were retrieved
    foreach ($items as $current) {
        echo "<p>$current->Phone ** $current->Date ** $current->MessageText</p>n";
    }
}
```

Actually _you cannot use this API_, because you have to have an account, and students can't get one. So the main purpose of going through the example is that you can use the same kind of code for other APIs that work like this one. But I have an account, and I've created a ColdFusion script that accesses the text service and then provides its own API, which outputs a selection of the data in its own XML format. This was created for a project in which we called the texts "tweets", so the XML format is:

```xml
<tweetset>
<tweet>
<index></index>
<key></key>
<name></name>
<phone></phone>
<date></date>
<text></text>
</tweet>
</tweetset>
```

This can be accessed at

        http://webdb.ucs.ed.ac.uk/ddm/ACEstaff/john/textsIn2.cfm?xml

(if you leave off the "?xml" then it ouputs [a listing in HTML that you can see on a normal web page](http://webdb.ucs.ed.ac.uk/ddm/ACEstaff/john/textsIn2.cfm)).

So we can have a script that does this:

```php
$TXTurl = "http://webdb.ucs.ed.ac.uk/ddm/ACEstaff/john/textsIn2.cfm?xml";  // My texts API URL

$crl = curl_init(); // creating a curl object
$timeout = 10;
curl_setopt($crl, CURLOPT_URL, $TXTurl);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
$xml_to_parse = curl_exec($crl);     // Execute the curl object
curl_close($crl); // closing the curl object
```

where in this case we don't want to use POST, and we don't have to supply any parameters (except the "?xml", which is always the same). Then we can work with the XML in exactly the same way as before, e.g.

```php

$parsed_xml = simplexml_load_string($xml_to_parse);
$items = $parsed_xml->tweet; // traversing the xml nodes to count how many "tweets" (texts) were retrieved

$numOfItems = count($items);
echo "<p>Got $numOfItems " . (($numOfItems == 1) ? "item" : "items") . "</p>n";  // Conditional prints "item" if numOfItems==1, else "items"

if ($numOfItems > 0) { // yes, some items were retrieved
    foreach ($items as $current) {
        echo "<p>$current->name ** $current->date ** $current->text</p>n";
    }
}
```

In this setup, texts have to be sent to the number for the service, which is **+44 131 510 3388**. To be routed to my account, the texts all have to start with one of a small set of _keywords_, which are: _id-idea, id-area, id-help_ and _id-name_. My ColdFusion script stores the texts in its own database, and if you send it a text of the form "id-name YOUR NAME", it will store YOUR NAME with your phone number. Then any text from that phone number will be associated with that name (and you can change it at any time by sending another id-name text). This is where the parameter "name" in the XML output comes from -- there is, of course, no "name" parameter in the original Texttools API. In the output from my API, texts with the "id-name" keyword do not appear at all; for other texts, the text is provided with the keyword stripped off, but the keyword is in the "key" parameter.

In the lecture, I went on to demo a Processing sketch that uses this API to fetch the texts and then displays them in a wacky way. This no longer works as an applet so I can't link to it on a web page, but the sketch can be downloaded [here](TweetExtractor4.pde). Just open it in Processing and run it.

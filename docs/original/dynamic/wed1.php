<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="deephome.css" />
<title>Dynamic Web Design</title>

<script type="text/javascript" src="scripts/jquery-latest.pack.js"></script>
<script type="text/javascript" src="scripts/thickbox.js"></script>

<style>
.content ul{
	list-style: decimal;
	line-height: 130%;
}

.content ul ul{
	list-style: none;
}

.content p{
	line-height: 110%;
}
</style>


</head>

<body>
	<div class="wrapper">
		
        
        <div class="content">	

        <h1>Cold Fusion</h1>
		<h2> Tutorial 1, Wednesday, January 16th</h2>
        <p>As we saw on Thursday, Coldfusion uses an HTML tag syntax.  Just like in HTML, we always have pairs of tags (an opening and a closing tag). Some tags may contain additional attributes, the values of which will be wrapped in quotes (&quot; &quot;).</p>
        <p>However, as a processing language (rather than merely a markup language), the type of work you can get your code to do might be more reminiscent of Actionscript.
</p>
<ul>
<li>Variables</li>

<ul>
<li>declare with cfset tag:</li>
<li>< cfset hello= "Uh, yeh.  Hi."/></li>
<li>< cfoutput></li>
<li>#hello#</li>
<li>< /cfoutput></li>
</ul>
   
<br/>
   
<li>Arrays</li>
	<ul>
<li>	declare array:</li>
<li>	< cfset arrayExample=ArrayNew(1) /></li>
<li>	Positions begin at 1.</li>
<li>	set value of a position:</li>
<li>	< cfset arrayExample[1]=”choice two”/></li>
	<br />
<li>	add a value to the end of the array:</li>
<li>	< cfset ArrayAppend(arrayExample, “choice four”)/></li>
<li>	add a value to the start of the array:</li>
<li>	< cfset ArrayPrepend(arrayExample, “choice one”)/></li>
<li>	insert a value into a slot (shifting others around):</li>
<li>	< cfset ArrayInsertAt(arrayExample, 3, “choice three”)/></li>
<br />
<li>	get array length:</li>
<li>	#ArrayLen(arrayExample)#</li>
</ul>

 <br/>


<li>For loops</li>
	<ul>
<li>	Use cfloop tags: </li>
<li>	< cfloop from=”1” to=”#ArrayLen(arrayExample)#” index=”i”></li>
<li>	< /cfloop></li>
<li>	index value can be used to reference the current number of the loop.</li>
</ul>

<br />

<li>Forms & arrays</li>
<ul>
<li>	HTML Forms:</li>
<li>	http://www.w3schools.com/html/html_forms.asp</li>
<li>	Using arrays to populate < select> tags.</li>
<li>	or Radio tags:</li>
<li>	< input type=”radio” name=”radiotest” value=”#arrayExample[i]#” />#arrayExample[i]#</li>
<li>	or checkboxes (input type ="checkbox")</li>
</ul>

<br />

<li>If statements in CF</li>
<ul>
	<li>cfif tag </li>
	<li>Using if and IsDefined to check a variables state:</li>
	<li>< cfif IsDefined(“Form.NameOfField”)></li>
</ul>

<br />

<li>Client side form validation with javascript (using the spry framework).</li>
<ul>
	<li>Client side validation vs server side validation</li>
    <li>Insert > Spry > Spry validation text field</li>
    <li>Click on "span id="sprytextfield#"</li>
    <li>You can now change how you wish to validate this field in the properties inspector.</li>
</ul>
	
            
		</div>
               <!-- <img class="chimneys" src="images/banana.png" />-->
	</div>
</body>

</html>

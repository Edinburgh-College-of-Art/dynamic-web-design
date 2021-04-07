---
layout: page
title: Server-side systems and database serving
author: "John Lee"
lecture: 2
---

- [Working with Databases using PHP](#working-with-databases-using-php)
- [Databases and web interfaces](#databases-and-web-interfaces)
- [Databases and SQL](#databases-and-sql)
- [Linking to databases using PHP](#linking-to-databases-using-php)
  - [Making a connection](#making-a-connection)
  - [Creating a query](#creating-a-query)
  - [Prepared statements](#prepared-statements)
  - [Getting results](#getting-results)
  - [In summary](#in-summary)
- [Putting the output on a web page](#putting-the-output-on-a-web-page)
- [Getting new data](#getting-new-data)

## Working with Databases using PHP

Once we start to accumulate material from forms, or any other data that
we want to present on web pages, things can become quite complicated
quite quickly. We might want to create forms that are already filled-in
with some of the information, and get people to add to them; we might
want to have quite elaborate HTML pages which just include at certain
points data that comes from constantly updated files about, say, prices
of items or descriptions of new additions.

In more sophisticated applications, data is typically organised using
databases. Increasingly, web sites are used for e-commerce purposes that
require them to present information that is constantly being updated
elsewhere (at the "back end") rather than through the user-facing web
site itself. They might be presenting product lines to customers, stock
control information to managers on an intranet, or many other things. Or
a web site might be presenting simpler, but still continually changing
data, such as a message-board or wiki type of application, or a "web
content management system" -- like, in fact, our own MSc Work in
Progress pages (created using WordPress, which is also based on PHP).

In all of these cases, usually the web pages are created dynamically
from a database, which is also liable to be updated by other people or
systems (perhaps using a web service API, which is something we'll look
at in the course, though not in these notes). In the rest of this
lecture, we look at a particular system which can achieve connecting to
a database, as well as a number of other things: PHP, in combination
with a MySQL database. This combination is perhaps the most commonly
encountered method of integrating databases to be found on the internet.

## Databases and web interfaces

There are again several commonly used ways of making use of databases in
the context of a web site. Microsoft, for instance, offers Active Server
Pages (ASP) or one can use Java (JSP). There are other proprietary
solutions, such as Adobe Coldfusion, but we will be using PHP. The other
options are less common and usually slightly more expensive, but there
are still many providers.

These systems don't just deal with databases. They can do all kinds of
processing, including formatting material, connecting to web services,
dynamically creating arbitrary HTML, javascript and CSS, etc.

The way the systems just mentioned essentially all provide for dealing
with material that may include database data is the same as we have seen
for PHP:

(a) define a whole language for describing dynamic material that can be
included in HTML pages, then

(b) embed these descriptions in ordinary HTML pages to make templates
and

(c) arrange for this language to be interpreted by the web server.

Then pages (as templates) can be designed freely, placed on the server
and conveniently augmented with all kinds of additional content at the
time they are served to the user.

## Databases and SQL

It is possible to use a variety of DB systems with PHP, e.g. Microsoft
Access, Oracle, etc. The particular database system we will be using is
MySQL, which is a free, server-based system very often used with PHP.
The database is maintained on a server that may be (and in our case is)
on a different machine from the web server, but PHP can get access to it
in just the same way.

[Further details about how to use MySQL locally are availablehere](additional14.html#MySQL).

First, let's take note of the usual structure of databases. We are for
present purposes only interested in very simple ones. These consist of
one or more _Tables_, where each table can be thought of as an array
with rows and columns. The rows are _records_, and within each record
the columns are _fields_. The table will have a name, and so will the
fields in each record. A database table is for most purposes very
similar to a simple _spreadsheet_.

The database is sometimes created and updated directly on-screen,
through some sort of user interface, rather like a spreadsheet; but in
the systems we are interested in this can also be achieved by using a
_query language._ The most common of these is the "Structured Query
Language", **_SQL_**, which was originally invented by IBM but is now
very widely used.

In SQL, one can state queries which may request information from the DB,
but also may create it, update it in various ways, or delete it. SQL for
our purposes can be used quite simply, though it is in fact very
sophisticated and can be used to do very complicated things in advanced
applications.

Here we'll assume that a very simple database with just one table
called _Product_ already exists and contains data about various
manufactured products. The _Product_ table has fields called:

```sql
Manufacturer, ManufacturerURL, ProductName, ProductType, ProductDescription, ProductPrice, ProductImage.
```

The main SQL commands that we'll mention are `SELECT`, `INSERT` and `UPDATE`. The first of these is, naturally, used to select the information that is
being requested, e.g.

```sql
SELECT fieldname1 fieldname2 ... FROM tablename
```

where in practice we would use the names of the table and fields we need
to address, whatever these are, for instance:

```sql
SELECT PruductName ProductType ... FROM Product
```

This can be qualified in various ways, most especially by using WHERE,
as in:

```sql
SELECT fieldname1 fieldname2 ... FROM tablename WHERE field=value
```

SQL is best understood by looking at examples. An example of this kind
of construction in relation to the data about products might be:

```sql
SELECT Manufacturer, ProductName, ProductType FROM Product WHERE ProductType=door
```

which would have the effect of selecting just these three fields from
all records in the Product table that have the value "door" in the
ProductType field.

The next most obvious thing to do with a database is insert data into
it, using the pattern:

```sql
INSERT INTO tablename(fieldname1, fieldname2, ...) VALUES(value1, value2, ...)
```

where the field names and values match up, as for example:

```sql
INSERT INTO Product(Manufacturer, ManufacturerURL, ProductName, ProductType, ProductDescription, ProductPrice, ProductImage) VALUES('Smith & Sons', 'http://www.smith.com/', 'Door 26', 'door', 'Wooden panelled', '87.25', 'http://www.smith.com/images/door26.jpg')
```

This would create a new _Product_ record with these values for all the
fields. One could specify values for just some of the fields, but the
fields named and the values given for them must always be provided in
the same order as each other. So:

```sql
INSERT INTO Product(Manufacturer, ProductName) VALUES('Smith & Sons', 'Door 26')
```

is also OK -- the other fields will take default values (typically
NULL, but you can specify other things if you like when you create the
database table to begin with).

Alternatively, one may need to update an existing record, for instance:

```sql
UPDATE Product SET ProductPrice = '92.63', ProductDescription = 'Wooden richly panelled' WHERE ProductName = 'Door 26'
```

-- if, say, the price of Door 26 has been changed and we want to update
its description. Of course, the identification of this record depends on
there being no other product called "Door 26" in the same table.
Usually DB systems provide unique identifiers for records to help with
identification.

Deleting records is dangerously easy; the character \* is available as a
"wildcard", so:

```sql
DELETE * FROM Product
```

will _delete all the records in the Product table_! So one needs to
restrict this, as in:

```sql
DELETE FROM Product WHERE ProductName = 'Door 26'
```

which will delete all records concerning any product called "Door 26".

Further examples of SQL will be seen as we progress, but for many
purposes you will not need to know much more about it than this. General
details of the language, with examples and tutorials, are easily found
in many textbooks and web sites.

## Linking to databases using PHP

Clearly the first step is to create a database. For our own purposes
we'll assume this is done directly with MySQL. It's quite possible to
create a database from scratch using PHP, but we assume here that the
database already exists. So the next step is to connect to it.

There are a number of different ways supported by PHP for creating and
working with connections to MySQL (and other) databases. In different
tutorials, books, code snippets etc., you may come across several of
these. Some of them are relatively outmoded and have been replaced with
better methods. Some are extremely insecure, in the sense that they
leave your application vulnerable to attack from malicious agents.

This is a very important consideration when doing anything with PHP. It
is so widely used that it is intensively targeted by hackers.
Consequently, very often, an older way of doing something will have
become vulnerable, and "easy" methods or short cuts are often
extremely hazardous. You might think this is a minor issue, but exploits
of PHP can easily be used to bring down a server machine or use it to
attack many others: this is bad enough in the University context, but in
the commercial world can be disastrous, so it is not to be taken
lightly.

**_In particular, it means you should be very careful when "borrowing"
PHP code from sites on the internet. Unless you are very sure of the
security and reliability of the source, do not use any code that you
have not read carefully and thoroughly understood (which is often
difficult with PHP code).This can apply equally to code that doesn't
access a database, especially if it uses some risky function such as
email._**

Connecting to a MySQL database from PHP normally requires you to know
the address of the database server, and login credentials for accessing
it. See local details [here](additional12.html#MySQL).

The particular method we will use for connecting to the database is
relatively easy to use securely, but is not the simplest or most
straightforward overall.We will not discuss the simplest method (which
uses e.g. the function _mysql_connect()_), because it is deprecated and
also will be dropped in PHP 6; but you will often find it in many other
places (including, unfortunately, the O'Reilly reference in
Dreamweaver, and at <http://www.w3schools.com/php/php_ref_mysql.asp>).
Please **_do not use these functions_** in your own code: use the method
described here, or some other that takes advantage of prepared
statements etc. **_Remember: DO NOT USE mysql_connect()_**.

Recent versions of PHP come with an extension that implements a better
way to access MySQL databases. PHP is _object-oriented_, just like
Actionscript and most other scripting languages you might encounter, and
this extension is offered as a series of objects that you can use to
create and manipulate database connections. It's called the "MySQL
Improved Extension", usually known as **_MySQLi_**. There is
documentation in the online manual at
<http://uk.php.net/manual/en/book.mysqli.php>, although this can be hard
to understand if you are not accustomed to reading such material. (Note
that the documentation also describes a "procedural", i.e not
object-oriented, version or style of this extension. We will always use
the object-oriented style because most new extensions are only available
in this form, and it's absolutely essential to know how to use it. This
is because it is much better.)

Objects in PHP are similar to those in Actionscript, having properties
and methods, but the syntax looks a little different. Instead of the
"dot", as in _object.property_, or _object.method()_, PHP uses a
two-character "arrow", as in _object->property_. Otherwise, things
are similar in that new objects are created using the operator _new_,
etc. The examples below are basically the same as examples in the
manual.

### Making a connection

So we begin by creating a new MySQLi object to establish the DB
connection (remembering the "\$" in variable names):

```php
    $mysqli = new mysqli("server", "username", "password", "database");
```

The arguments to this are _strings_ (hence in quotes), and should be
your own individual credentials for accessing your DB on our server.
(Or, if you have installed MAMP or similar on your own machine, then the
server can be "127.0.0.1" and the rest whatever you have defined in
your MySQL instance. In fact, if your code is running on playground,
then it's on the same machine as the MySQL server, and so you can use
the form "127.0.0.1", or simply "localhost", there as well.)
"$mysqli" is just a variable, which we could have called anything at
all; it's called *$mysqli\* just to make it easy to remember what it
is.

It's now a good policy to check the connection, because if it has
failed then going further will cause unpleasant errors.

```php
    if ($mysqli->connect_errno) {
       printf("Connect failed: %sn", $mysqli->connect_error);
       exit();
    }
```

Here we exploit the fact that the _mysqli_ object has two properties,
_connect_errno_ and _connect_error_, where the first is non-zero if
there is an error, and in that case the second contains a string
describing the error.

The function _printf()_ is an extremely useful way to construct output
strings, often used by traditional programmers and hence often found in
example code, especially in the manual (see also
<http://uk.php.net/manual/en/function.printf.php>). In this case, it is
equivalent to saying:

```php
       echo "Connect failed: " . $mysqli->connect_error . "n";
```

-- which is arguably clearer.

### Creating a query

If there is no error at this stage, then we have a functioning database
connection. The next step is to create a query. In sufficiently simple
cases, we can do this simply by writing some SQL as a string and sending
it to MySQL:

```php
    if ($result = $mysqli->query("SELECT * FROM Product"))   {
       printf("Select returned %d rows.n", $result->num_rows);
    }
```

Here [$result]{.style4} is a variable that will be set to a
_mysqli_result_ object as "resultset" (if the _query()_ method
returns a non-zero value), and we can then extract information from it,
e.g. in this case the number of rows it contains.

### Prepared statements

However, with more complex queries this simple method is fraught with
danger, since there are ways in which malicious agents could get hold of
the query and mess around with it (leading to a dangerous type of attack
called _SQL injection_). For safety, we instead create a **_prepared
statement_**. This is a mechanism that packages up the query in a
particular way which makes it safer (and for certain kinds of query also
makes it substantially more efficient). Basically, we do this whenever
our query is going to contain as parameters explicit values in the
database, and especially where anything is being inserted into the
database.

It works by taking the query and putting into it placeholders for the
parameters that we want to query the database about, or update. Thus a
query such as

```sql
SELECT Manufacturer, ProductName, ProductType FROM Product WHERE ProductType=door
```

becomes

```sql
SELECT Manufacturer, ProductName, ProductType FROM Product WHERE ProductType=?
```

where the "?" is a placeholder for the parameter value "door".
Placeholders are used for values that are actual data values in the DB,
i.e. not column names or table names, but data values. Note that if
there are several placeholders, they are all represented as "?"s, so
there could be a number of these, say as in:

```sql
INSERT INTO Product(Manufacturer, ProductName) VALUES(?,?)
```

The prepared statment is then created thus:

```php
    $stmt = $mysqli->prepare("SELECT Manufacturer, ProductName FROM Product WHERE ProductType=?")
```

Here, again, "\$stmt" is just a variable, which you could use any name
for. But the _mysqli->prepare()_ method returns a _mysqli statement_
object, which we now work with to create and perform the query itself.
We do this by binding the placeholders to specific variables, which we
create and give values. For instance:

```php
    $stmt->bind_param("s", $prodtype);
    $prodtype = "door";
```

We are here calling the _bind_param()_ method of the _mysqli_stmt_
object that is represented by _\$stmt_. What the call says is that we
are binding a _string_ (hence the "s") to the first parameter ("?")
in the prepared statement, and this string will be provided in the
variable _\$prodtype_. If there are several parameters, we give these as
separate variables **_in the order that they appear in the prepared
statement_**, e.g. for the INSERT example above we might have:

```php
    $stmt->bind_param("ss", $manuf, $prodname);
    $manuf = 'Smith & Sons';
    $prodname = 'Door 26';
```

In this case, "ss" says that we will be giving _two_ parameters which
are both strings. Other possible types pf parameters are integer, double
and "blob", which are indicated by the letters "i", "d" and "b",
respectively.

So now we have the statement ready with its parameters bound, we can
_execute_ it:

```php
    $stmt->execute();
```

What could be simpler? -- A nice feature of this arrangement is that it
always uses the statement we prepared with the variables we bound to it,
but we can change their values. So if we are doing several updates, for
instance, we can simply change the variable values and execute again,
without re-preparing or re-binding the statement.

At this point, the query is being executed on the database in MySQL, so
if it's a SELECT query then there will (if all goes well) be a
_resultset_ of data returned to PHP for us to work with. A resultset is
basically a collection of records (rows), with columns (fields)
corresponding to what we asked for in the query, e.g. in this case
values for Manufacturer and ProductName.

### Getting results

In MySQLi the best way to work with results is to bind variables to
them, and then use these variables to extract the values. In our
example, we were extracting data about the Manufacturer and ProductName,
so we bind a variable for each of these:

    $stmt->bind_result($manuf, $prodname);

Now we call the _fetch()_ method in the statement object, and if we call
it more than once it will repeatedly fetch each row in the resultset
until there are none left (and then it will return **_false_**). Each
time, it will put the values in the row retrieved into the variables we
have just bound. So if we have a loop like this:

```php
    while ($stmt->fetch()) {                    // keep going until fetch returns false
       printf("%s %sn", $manuf, $prodname);
    }
```

we will get a line printed for each row in the resultset, i.e. each row
in the data table where the ProductType was "door".

### In summary

In the end, we should close down the objects we created, to free memory.
So overall, the code for this example is just:

    $mysqli = new mysqli("server", "username", "password", "database");
    if ($mysqli->connect_errno) {
       printf("Connect failed: %sn", $mysqli->connect_error);
       exit();
    }
    if ($stmt = $mysqli->prepare("SELECT Manufacturer, ProductName FROM Product WHERE ProductType=?")) {
       $stmt->bind_param("s", $prodtype);
       $prodtype = "door";
       $stmt->execute();
       $stmt->bind_result($manuf, $prodname);
       while ($stmt->fetch()) {
          printf("%s %sn", $manuf, $prodname);
       }
       $stmt->close();
    }
    $mysqli->close();

Not really so bad? -- Notice that here we additionally put the call to
_\$mysqli->prepare()_ in a conditional, so that we don't attempt to
use the statement if preparing it fails for some reason.

## Putting the output on a web page

Outputting the results of the query can be done in many different ways.
Here's a simple way to embed the code above (adding MaufacturerURL and
ProductImage for interest) into HTML in a template that creates a table
presenting the data in the query (in this case, a slightly more
interesting query). We can take advantage of any features of HTML that
we like, so for instance instead of just printing out the URL it's easy
to make it into a clickable link. We could also of course style this
page by simply adding any required id or class attributes and some CSS
styles or a link to a stylesheet.

    <TABLE CELLPADDING="3" CELLSPACING="0">
    <TR BGCOLOR="#888888">
    <TH>Manufacturer</TH>
    <TH>Manufacturer URL</TH>
    <TH>Product Name</TH>
    <TH>Product Image</TH>
    </TR>

    <?php
       /* create connection */
       $mysqli = new mysqli("duchamps.caad.ed.ac.uk", "john", <MY_PASSWORD>, "johntest");

    /* check connection */
       if ($mysqli->connect_errno) {
       printf("Connect failed: %sn", $mysqli->connect_error);
       exit();
       }

       /* create prepared statement */
       if ($stmt = $mysqli->prepare("SELECT Manufacturer, ManufacturerURL,   ProductName, ProductImage FROM Product WHERE ProductType=?")) {

     /* bind parameter(s) for placeholder(s) */
       $stmt->bind_param("s", $prodtype);
       $prodtype = "blind";

     /* execute query */
       $stmt->execute();

     /* bind result variable(s) */
       $stmt->bind_result($manuf, $manufURL, $prodname, $prodimg);

       /* fetch values */
       while ($stmt->fetch()) {
           /* output data values embedded into HTML */
           echo "<TR BGCOLOR='#BBBBBB'>n";
           echo "<TD>" . $manuf . "</TD>";
           echo "<TD><A HREF='". $manufURL . "'>". $manufURL   . "</A></TD>";
           echo "<TD>" . $prodname . "</TD>";
           echo "<TD><img src='" . $prodimg . "'></TD>";
           echo "<TR>n";
       }

       /* close statement */
       $stmt->close();
       }
       /* close connection */
       $mysqli->close();
       ?>

    </TABLE>

You can see this at
<http://playground.eca.ed.ac.uk/~jlee/test/prod-data-view.php>.
The first block of HTML here simply creates the first row of the table,
with a background of a particular shade of grey, which just contains the
column headings.

A second block is constructed within a while loop that creates more
rows, one for each DB record. This is exactly like the example in the
PHP Database Tutorial
[(http://playground.eca.ed.ac.uk/~jlee/PHP-DatabaseTutorial/](http://playground.eca.ed.ac.uk/~jlee/PHP-DatabaseTutorial/)),
except that here I've used _echo_ to print out the HTML from within the
one PHP script, whereas in the tutorial a number of separate script
elements are embedded in the HTML. You can do it either way.

One could write all this HTML directly in a text editor (I used
TextWrangler), but also one can use an editor like Dreamweaver to create
at least some of it. Also, Dreamweaver is able to maintain information
about data connections specifically, and knows about PHP. So although
you may still have to write PHP scripts directly, Dreamweaver can show
you immediately what the page looks like with the live data included. On
the other hand, previewing in a (variety of) browser(s) will always give
you a better idea of what the page will really look like, and in the end
it's much quicker to write code directly in a text editor once you have
learned how.

Since the data we are displaying on the page we are creating here is
tabular data, it makes sense to use a table to present it, and we can do
this using normal HTML table tags. In other cases, we might want to use
CSS for formatting. That's fine: PHP will work just as well in
conjunction with CSS. (We could even, if we wanted, write PHP code to
generate or adapt CSS dynamically, so that things would be formatted
differently in different circumstances.)

## Getting new data

We now finally get back to our discussion of forms ...

PHP is a very good environment for processing forms that will collect
new data to be added to an existing DB table. PHP will also, of course,
support arbitrary processing of data before it's presented, e.g.
calculations on numbers or rearranging strings, etc.

The PHP Database Tutorial
(<http://playground.eca.ed.ac.uk/~jlee/PHP-DatabaseTutorial/>) shows you
how to do this. Always remember that taking data from a form and
inserting it into a database is a very vulnerable operation with several
major security risks: **_always_** make sure that you use prepared
statements appropriately.

This has been a very simple introduction, but still you need no more
than is covered in these notes and the tutorials to make some very
effective dynamic web sites.

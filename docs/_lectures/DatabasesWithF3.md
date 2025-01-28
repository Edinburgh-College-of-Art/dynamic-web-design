---
layout: page
title: "Server-side systems and database serving 2: working with databases"
author: "John Lee"
order: 3
week: 1
---

-   [Working with Databases using PHP and the Fat-Free Framework](#working-with-databases-using-php-and-the-fat-free-framework)
    -   [Databases and web interfaces](#databases-and-web-interfaces)
    -   [Databases and SQL](#databases-and-sql)
        -   [A brief overview of basic SQL (optional)](#a-brief-overview-of-basic-sql-optional)
    -   [Linking to databases using PHP](#linking-to-databases-using-php)
    -   [Working with databases using F3](#working-with-databases-using-f3)
        -   [Setting up a connection](#setting-up-a-connection)
        -   [**Using a connection in an application**](#using-a-connection-in-an-application)
    -   [Managing input and output via web pages](#managing-input-and-output-via-web-pages)

# Working with Databases using PHP and the Fat-Free Framework

Once we start to accumulate material from forms, or any other data that we want to present on web pages, things can become quite complicated quite quickly. We might want to create forms that are already filled-in with some of the information, and get people to add to them; we might want to have quite elaborate HTML pages which just include at certain points data that comes from constantly updated files about, say, prices of items or descriptions of new additions.

In more sophisticated applications, data is typically organised using databases. Ubiquitously, web sites are used for e-commerce purposes that require them to present information that is constantly being updated elsewhere (at the "back end") rather than through the user-facing web site itself. They might be presenting product lines to customers, stock control information to managers on an intranet, or many other things. Or a web site might be presenting simpler, but still continually changing data, such as a message-board or wiki type of application, or a "web content management system" such as WordPress (which is built using PHP), etc.

In all of these cases, usually the web pages are created dynamically from a database, which is also liable to be updated by other people or systems (perhaps using a web service API, which is something we'll look at in the course, though not in these notes). In the rest of this lecture, we look at a particular system which can achieve connecting to a database, as well as a number of other things: PHP, in combination with a MySQL database. This combination is perhaps the most commonly encountered method of integrating databases to be found on the internet, but it is also widely misused. Using the "Fat-Free Framework" (F3) will enable us easily to avoid many of the worst pitfalls in this area.

## Databases and web interfaces

There are again several commonly used ways of making use of databases in the context of a web site. Microsoft, for instance, offers Active Server Pages (ASP) or one can use Java (JSP). There are other proprietary solutions, such as Adobe Coldfusion, and open-source ones such as Django (based on python), but we will be using PHP. The other options are less common and often more expensive, but there are still many providers.

These systems don't just deal with databases. They can do all kinds of processing, including formatting material, connecting to web services, dynamically creating arbitrary HTML, javascript and CSS, etc.

The way the systems just mentioned essentially all provide for dealing with material that may include database data is the same as we have seen for PHP:

(a) define a whole language for describing dynamic material that can be included in HTML pages, then

(b) embed these descriptions in ordinary HTML pages to make templates and

(c) arrange for this language to be interpreted by the web server.

Then pages (as templates) can be designed freely, placed on the server and conveniently augmented with all kinds of additional content at the time they are served to the user.

## Databases and SQL

It is possible to use a variety of DB systems with PHP, e.g. Microsoft Access, Oracle, etc. The particular database system we will be using is MySQL, which is a free, server-based system very often used with PHP. The database is maintained on a server that may be (but in our case is not) on a different machine from the web server: in any case, PHP can get access to it in just the same way.

[Further details about how to use MySQL locally are available here](additional.html#MySQL).

First, let's take note of the usual structure of databases. We are for present purposes only interested in very simple ones. These consist of one or more _Tables_, where each table can be thought of as an array with rows and columns. The rows are _records_, and within each record the columns are _fields_. The table will have a name, and so will the fields in each record. A database table is for most purposes very similar to a simple _spreadsheet_.

The database is sometimes created and updated directly on-screen, through some sort of user interface, rather like a spreadsheet; but in the systems we are interested in this can also be achieved by using a _query language._ The most common of these is the "Structured Query Language", **_SQL_**, which was originally invented by IBM but is now very widely used. (Sometimes it's pronounced "Sequel", but I prefer S-Q-L.)

In SQL, one can state queries which may request information from the DB, but also may create it, update it in various ways, or delete it. SQL for our purposes can be used quite simply, though it is in fact very sophisticated and can be used to do very complicated things in advanced applications.

_Now, here is an important point: when we are using the Fat-Free Framework (F3), as well as many other frameworks, **we often do not need to write any SQL at all**! This is because the F3 mechanism described in the next two sections allows database tables to be queried, updated, deleted from, etc. without explicitly using SQL but just using functions that hide all the SQL in the background. As long as we are only doing simple operations, we don't need to use SQL directly. It becomes useful for more complex database operations, but you may not need these for a simple application. The following subsection explains how SQL is used for simple database operations, but to begin with you may consider this optional._ _If you end up developing functionality that is more complex, you may need to return to it later and extend it further._

### A brief overview of basic SQL (optional)

Here we'll assume that a very simple database with just one table called _Product_ already exists and contains data about various manufactured products. The _Product_ table has fields called: `Manufacturer, ManufacturerURL, ProductName, ProductType, ProductDescription, ProductPrice, ProductImage.`

The main SQL commands that we'll mention are SELECT, INSERT and UPDATE. The first of these is, naturally, used to select the information that is being requested, e.g.

`SELECT fieldname1 fieldname2 ... FROM tablename`

where in practice we would use the names of the table and fields we need to address, whatever these are, for instance:

`SELECT ProductName ProductType ... FROM Product`

This can be qualified in various ways, most especially by using WHERE, as in:

`SELECT fieldname1 fieldname2 ... FROM tablename WHERE field=value`

SQL is best understood by looking at examples. An example of this kind of construction in relation to the data about products might be:

`SELECT Manufacturer, ProductName, ProductType FROM Product WHERE ProductType=door`

which would have the effect of selecting just these three fields from all records in the Product table that have the value "door" in the ProductType field.

The next most obvious thing to do with a database is insert data into it, using the pattern:

`INSERT INTO tablename(fieldname1, fieldname2, ...) VALUES(value1, value2, ...)`

where the field names and values match up, as for example:

`INSERT INTO Product(Manufacturer, ManufacturerURL, ProductName, ProductType, ProductDescription, ProductPrice, ProductImage) VALUES('Smith & Sons', 'http://www.smith.com/', 'Door 26', 'door', 'Wooden panelled', '87.25', 'http://www.smith.com/images/door26.jpg')`

This would create a new _Product_ record with these values for all the fields. One could specify values for just some of the fields, but the fields named and the values given for them must always be provided in the same order as each other. So:

`INSERT INTO Product(Manufacturer, ProductName) VALUES('Smith & Sons', 'Door 26')`

is also OK -- the other fields will take default values (typically NULL, but you can specify other things if you like when you create the database table to begin with).

Alternatively, one may need to update an existing record, for instance:

`UPDATE Product SET ProductPrice = '92.63', ProductDescription = 'Wooden richly panelled' WHERE ProductName = 'Door 26'`

\-- if, say, the price of Door 26 has been changed and we want to update its description. Of course, the identification of this record depends on there being no other product called "Door 26" in the same table. Usually DB systems provide unique identifiers for records to help with identification.

Deleting records is dangerously easy; the character \* is available as a "wildcard", so:

`DELETE * FROM Product`

will _delete all the records in the Product table_! So one needs to restrict this, as in:

`DELETE FROM Product WHERE ProductName = 'Door 26'`

which will delete all records concerning any product called "Door 26".

Further examples of SQL abound, but for many purposes you will not need to know much more about it than this. General details of the language, with examples and tutorials, are easily found in many textbooks and web sites, as well as [the copious documentation of MySQL](https://dev.mysql.com/doc/refman/8.0/en/).

## Linking to databases using PHP

Clearly the first step is to create a database. For our own purposes we'll assume this is done directly with MySQL. It's quite possible to create a database from scratch using PHP, but we assume here that the database already exists and contains the table(s) we need. So the next step is to connect to it.

There are a number of different ways supported by PHP for creating and working with connections to MySQL (and other) databases. In dfferent tutorials, books, code snippets etc., you may come across several of these. Some of them are relatively outmoded and have been replaced with better methods. Some are extremely insecure, in the sense that they leave your application vulnerable to attack from malicious agents.

Security is a very important consideration when doing anything with PHP. It is so widely used that it is intensively targeted by hackers. Consequently, very often, an older way of doing something will have become vulnerable, and "easy" methods or short cuts are often extremely hazardous. You might think this is a minor issue, but exploits of PHP can easily be used to bring down a server machine or use it to attack many others: this is bad enough in the University context, but in the commercial world can be disastrous, so it is not to be taken lightly.

**_In particular, it means you should be very careful when "borrowing" PHP code from sites on the internet. Unless you are very sure of the security and reliability of the source, do not use any code that you have not read carefully and thoroughly understood (which is often difficult with PHP code). This can apply equally to code that doesn't access a database, especially if it uses some risky function such as email._**

We will not discuss the various methods of connecting to databases using PHP outside of F3. You will find much code on the internet that is based on such methods, including especially the oldest and simplest method, which uses the function `mysql_connect()`. This function, along with others associated with it, is extremely unsafe, **deprecated** and dropped in later versions of PHP, but you will often find it in many places. Please **_do not use these functions_** in your own code: use the method described here, with F3. **_Remember: DO NOT USE `mysql_connect()` in ANY circumstances_**.

We will assume from here that you are not going to connect to your MySQL database directly from lower-level PHP code, but only through functions provided by the Fat-Free Framework.

## Working with databases using F3

### Setting up a connection

In F3, the making of a database connection is represented, using an object-oriented programming approach, as a specific class that contains a method (function) which sets up the connection. In F3, we will normally put this in an _Autoload_ folder, so that it will be automatically loaded and made available to the application. Because we may have a number of F3 applications that use the same database connection class, and because we do not want any database connection details to be visible on the web where hackers might get at them, we keep the database connection class in an _Autoload_ folder **_above the web root._** This means it's in a folder that is not inside the `html` folder where everything that's web-visible has to be. So we simply create a folder called "AboveWebRoot" (for clarity, though in fact it can be called anything) that is at the _same level_ as the `html` folder, rather than inside it. This folder is useful for other things that we want to keep away from possible hackers, and things that we'd like to make easily available to all our F3 applications.

Connecting to a MySQL database from PHP, even with F3, requires you to know the address of the database server, and login credentials for accessing it. See local details [here](additional21.html#MySQL). We use these in setting up the database connection. So inside the above web root Autoload folder, we have a class called _DatabaseConnection_, which is defined in a file called _DatabaseConnection.php_. (You should always define autoload classes in a file of the same name, with the _.php_ extension, and the file should contain nothing except the class definition and comments.) It looks like this:

```php
class DatabaseConnection
{
    static function connect()
    {
        return new DBSQL(
            'mysql:host=hostName;port=portNumber;dbname=databaseName',
            'username',
            'password'
        );
    }
}
```

The items shown here in red are as given in the local details. The hostName can be "localhost" if your code is run by a PHP server hosted on the same server host as the MySQL database itself (e.g. Edinburgh Domains). The `connect()` method returns a _DBSQL_ object, which is an F3 component that holds an SQL database connection.

In our application's _index.php_ file, we invoke the above method with the following line of code:

`$db = DatabaseConnection::connect();`

This invokes the method _statically_, which means without creating an object of the DatabaseConnection class, because we would have no further use for the object; all we want is the _DBSQL_ connection object. The variable `$db` now contains the connection, and we then put it into a global F3 variable `DB`, for further use as we'll see below:

`$f3->set('DB', $db);`

(note that `DB` is not a PHP variable -- it's an F3 variable -- and so it is named as a string, using quotes, and doesn't have the `$` in front of it that PHP variables must always have).

### Using a connection in an application

Using the Model-View-Controller (MVC) approach, one thinks of the database as being the _Model_. It provides a representation of relevant information about the domain we're working with. Code that controls how information goes into and out of the database we can think of as the _Controller_. Taking an object-oriented approach, it will be implemented as a _class_ that contains _methods_ (functions) to carry out the various actions that are needed. Defining a class allows _objects_ of that class to be created.

Objects in PHP are similar to those in Javascript, having properties and methods, but the syntax looks a little different. Instead of the "dot", as in `object.property`, or `object.method()`, PHP uses a two-character "arrow", as in `object->property`. Otherwise, things are similar in that new objects are created using the operator `new`, etc. (We saw above that PHP also uses the double-colon, as in `object::method()`, when working with classes statically; but we will rarely need to use this.)

Normally we will define a class suitable for our specific application: in the case of the SimpleForm application it's called _SimpleController_. This is defined in a file called _SimpleController.php_, which is placed in the application's Autoload folder (note that this is **_not_** the same as the AboveWebRoot Autoload folder), so that it will always be automatically loaded and available to PHP. The code for this is as follows:

```php
<?php
// Class that provides methods for working with the form data.
// There should be NOTHING in this file except this class definition.

class SimpleController
{
    private $mapper;

    public function __construct()
    {
        global $f3;                     // needed for $f3->get()
        $this->mapper = new DBSQLMapper($f3->get('DB'), "simpleModel");    // create DB query mapper object
        // for the "simpleModel" table
    }

    public function putIntoDatabase($data)
    {
        $this->mapper->name = $data["name"];                    // set value for "name" field
        $this->mapper->colour = $data["colour"];                // set value for "colour" field
        $this->mapper->save();                                    // save new record with these fields
    }

    public function getData()
    {
        $list = $this->mapper->find();
        return $list;
    }

    public function deleteHandler($idToDelete)
    {
        $this->mapper->load(['id=?', $idToDelete]);               // load DB record matching the given ID
        $this->mapper->erase();                                   // delete the DB record
    }

}

?>
```

In the _SimpleController_ class, I have assumed that whenever an object of this class is created, the first thing it will need is a way to use the connection to the database, so this is defined in the special method `__construct()`, which is automatically called whenever a new object of this class is created (constructed). (This kind of method is commonly known in object-oriented programming as a _constructor_.)

The way to use a database connection in F3 is via a _mapper_ object, which very cleverly manages all the relationships between data in a particular database table and variables in our PHP code. Hence the first thing in the SImpleController definition is creating a variable (`$mapper`) for a mapper object. This mapper object is identified in the `__construct()` method as `$this->mapper`, where `$this` identifies the particular object that is being created when the code is run ("this object", to the code). The mapper object is created using `new DBSQLMapper($f3->get('DB'),"simpleModel")`, because we are creating a new `DBSQLMapper` object (which is part of F3), giving it the reference to our own database connection that we saved before (which we now access using `$f3->get('DB')`) and the name of the database table we want to map to (`simpleModel`).

The way the mapper object works is that if there is a field in the database table, say _field1_, then there is a property in the mapper object that's also called _field1,_ and the values of these are mapped to each other. Hence, we have methods in the SimpleController class that can manipulate data in the table by accessing properties of the mapper object. Thus, data can be put into the table using the `putIntoDatabase($data)` method, where `$data` is an array of values, and when we write `$this->mapper->name = $data["name"]` we are saying that the property of the mapper object called _name_ (`$this->mapper->name`) should be set to the element called _name_ in the `data` array. Note that we did not have to use an array here, or use keys in the array that match the database fields; we could just as well say `$this->mapper->name = "Fred"` -- no matter how we set the value of `$this->mapper->name`, F3 will arrange that when we call `$this->mapper->save()`, a new record will be made in the table, and the fields will be given values that we have assigned to mapper properties that have the same names. This is all done for us, using SQL behind the scenes, which makes everything much simpler.

F3 also provides mapper methods to retrieve and delete data, which we exploit in defining the remaining methods of _SimpleController_. The code here may look a little complicated, but it is much simpler than the code you need if you use relatively "vanilla" PHP approaches to working with databases (such as the MySQLi extension as described at w3schools and elsewhere). The F3 mapper system incorporates important security features that are even more complicated to implement using other approaches, which makes this a very much safer way to implement database connections in our applications.

## Managing input and output via web pages

The most typical way to get information from a web site user is via a form, and with F3 the standard way to put information onto a web page is to define a template that contains F3 variables with values that will be resolved when the template is rendered. The variables can then take values that are derived form the database, and hence the database data can be output to a web page. We have already seen how forms can be used, and the code considered there got to the point where it called a method defined in the SimpleController class, which is `putIntoDatabase()`. This method takes an associative array of values where the keys in the array have the same names as the fields in the database table that we'd like to put them into, in the SimpleExample case being _name_ and _colour_. Because F3 does so much for us already, the definition of the function is very simple:

```php
public function putIntoDatabase($data) { 
	$this->mapper->name = $data["name"]; // set value for "name" field 
	$this->mapper->colour = $data["colour"]; // set value for "colour" field 
	$this->mapper->save(); // save new record with these fields 
}
```

All this does is set the members of the mapper object to take the values that are given in the $data array, and then call the mapper's `save()` method, which saves the values in the mapper object into the corresponding database fields (by using SQL behind the scenes). That's really all there is to it.

Retrieving data from the database is, in a simple case, even more straightforward. If you simply want to retrieve all the data in the data table, then the following method

```php
public function getData() { $list = $this->mapper->find(); return $list; }
```

achieves this by using the `find()` method of the mapper object, which if given no arguments will simply find all the data. The returned data will actually be in the form of an array containing one object for each row in the database table. Each of these objects is an associative array [conceptually -- in fact it's a more complex "mapper object", but it can be converted into an associative array], or in other words a list of key-value pairs, where the keys will be the names of the database fields and the values will be whatever value that field has in the particular row. This array-like object is returned from the method function using the variable `$list`. The object can be used in a template in a simple loop to display the data, e.g. as a table.

This is shown in the notes under Templates, repeated here. Suppose we have an F3 variable whose value is an array (it could be an array of strings, or numbers, or an associative array). Then we can loop through the array and produce HTML, for example a table, that includes all of the values in it:

{% raw %}
```php
<table>
    <tr>
        <th>Name</th>
        <th>Colour</th>
    </tr>
    <repeat group="{{ @dbData }}" value="{{ @record }}">
        <tr>
            <td>{{ trim(@record.name) }}</td>
            <td>{{ trim(@record.colour) }}</td>
        </tr>
    </repeat>
</table>
```
{% endraw %}

Here, between the `<repeat>` tags, we have a table row with two cells. Attributes of the opening tag are _group_ and _value_. The group is set to an F3 variable that contains an array; the value is used to create an F3 variable (`record`) that will hold one of the array members each time round the loop. Each member of the array contains a further associative array, each with keys name and colour. The expression `trim(@record.name)` simply takes the `name` element in the current `record` and trims any leading or trailing white space from it. So this `repeat` loops through the array, and for each element in it produces a row in the HTML table that puts the name and the colour into separate cells, as you can see in SimpleExample by using the _dataView_ route (URL ending in _/dataView_) -- this HTML is from the template _dataView.html_.

In the index.php file, a rule is defined for the _dataView_ route as follows:

```php
$f3->route('GET /dataView', function($f3)
{
    $controller = new SimpleController;
    $alldata = $controller->getData(); $f3->set("dbData", $alldata);
    $f3->set('html_title','Viewing the data');
    $f3->set('content','dataView.html');
    echo template::instance()->render('layout.html');
});
```

which straightforwardly creates a *SimpleController* object, then uses its *getData()* method as above to retrieve all the rows, which are put into the variable *$alldata*. This variable is then used to set an F3 variable *dbData*, which is expected in the _dataView.html_ template, as above.

This has been a very simple introduction, but still you need no more than is covered in these notes and the viewtorials to make some very effective dynamic web sites using F3.

---
layout: page
title: Additional information on local use of ColdFusion and MySQL
author: "John Lee"
---

### Connecting to the EUCS (IS) ColdFusion server

The overall picture of the situation is like this:

![](diagram.jpg){width="761" height="507"}

You can connect to the CF server very easily from a Mac OS X machine, by
using the Samba protocol (often used for connecting to Windows
machines). **Note that you will have to be on the University network or
the VPN** -- see the foot of this page for details. Type Command-K
(AppleKey-K) in the Finder, to get the Connect to Server dialogue. Then
enter (or choose from the menu if it's already there) the following
URL:

smb://webdbdev.ucs.ed.ac.uk/ddm1011

-- this should bring up a box in which you need to enter your
University Universal Username (UUN) and password (the same as you use
for accessing SMS mail etc.). You should then, perhaps after some delay,
simply get a normal-looking Finder window called _ddm1011_, with a lot
of other folders in it, including one named with your UUN. There is also
one called _test_ (containing the examples in these notes, among other
things). You will be able to read the material in most of these folders,
but you should only be able to write, or create new folders and files,
in your own folder. Feel free to create anything you like in your own
folder and experiment with copying and editing CF templates in it. Any
CF template that you put here, if its filename ends in ".cfm", should
be interpreted by the ColdFusion server as described in these notes.

Please don't create files anywhere else on this server, even if it
turns out that you can. Please also note that we do not have unlimited
disc space available on this server (and in fact you have a limited
quota allocation), so if you have many or large images etc. in your
pages it will be best to keep these on our DDM server and include them
in your pages by using their URLs.

The top-level folder you get to through this process is visible on the
web as
[http://webdbdev.ucs.ed.ac.uk/ddm/1011/](http://webdbdev.ucs.ed.ac.uk/ddm/2007/)
. Your folder, and other folders you create in it, will be visible at a
URL created by extending this one in the obvious way. Please note that
these URLs are currently visible to the world, so be aware of this and
consider issues of copyright and suitability when placing material on
this server.

### Using MySQL

MySQL is a powerful database system which one traditionally interacts
with on a UNIX command-line, entirely by writing SQL commands. This is
hugely flexible, but not very attractive. Luckily there is a very neat
freeware graphical interface that runs under OS X and generates the SQL
commands for you. MySQL is also server-based, which means that for our
purposes we will always be using databases provided by the MySQL server
running on our own server, duchamps.

To access the databases, use the application _SequelPro_. (See
<http://www.sequelpro.com/> for details.) When it's launched, type
Command-N (or choose New from the File menu) to create a new connection.
A dialogue box asks for various things -- enter the following:

Host: bacon.caad.ed.ac.uk
User: mscuser1011
Password: <will be given to you more securely than by publication here
...>

(ignore the other fields at this stage). There may be a short wait while
the connection is made. The title bar of the window will indicate the
connection once you have one. The interface will look rather like this
(click for full-size image) -- though the database is actually called
_mscdb1011_ this year:

![](img/mySQLscreen.png)

The console at the bottom can be displayed with the buttons at the top
left. It shows you the SQL commands that are being sent to the server,
and you'll see that some of these are similar to the ones you have to
write in ColdFusion -- you can write other specific queries and test
out what they do by using the "Custom Query" tab. The Databases list
at the upper left shows you the databases that the server can serve.
However, you do not have privileges to access all of these. By
convention, everyone can access the database _test_.

You should also be able to access the database called _mscdb1011_, and
you should have full privileges to create, change and delete tables in
it. **Be very careful with this!** **If you change or delete something,
there is NO WAY OF UNDOING IT!** (If you are considering a major change
to a table that might be important, ALWAYS make a duplicate copy of it
first, just in case.)

You can create your own tables, or tables for use by groups. When
you've created a table, you have to add specifications of fields one at
a time, in the "Structure" view as shown above (similar e.g. to the
"Design" view in MS Access). You can then change to the "Content"
view and add and edit the table rows (much as in the "Datasheet" view
in Access or similar things in FileMaker etc.).

You can also define keys and relationships between the tables. Consult
the SequelPro Help information, and a reference text on SQL for further
information. The very good database chapter in the SAMS ColdFusion book
(called "Day 4") assumes you are using MS Access, but the ideas are
much the same. There is also (extremely extensive) [online MySQL
documentation](http://dev.mysql.com/doc/refman/4.1/en/index.html).

Remember that in the database _mscdb1011_, you are all in effect the
same user, so you can all read and change each other's tables --- do
please therefore **_exercise appropriate care and respect in your use of
this database_**. Later, we can set up databases with other kinds of
permissions if needed.

We assume that for our purposes here, we will mostly only need to create
tables and specify the types for all the fields. That is, we will only
need to create the Structure (or Design) of the database. Then content
will normally be added and manipulated via ColdFusion, although it is
also possible to import data from files, even e.g. data files exported
from other databases created in Access or Excel etc.

Notice that MySQL data fields can contain all kinds of things, including
image data; but usually we will want to keep images as files on a web
server, and simply include the URL in the database.

### Accessing MySQL from ColdFusion

You can only access datasources in CF if these have been registered by
the CF server administrators. We have one that is set up for the
mscdb1011 mentioned above. **The datasource name is "mscdb1011": note
that this can be*different* from the name of the database itself, but in
this case it's the same.** If you have created, say, a table in there
called "flowers" with fields such as "name", "colour", "height"
and "smell", then you can create CF queries in your templates, such as
the following:

<CFQUERY NAME="FlowerData" DATASOURCE="mscdb1011">
SELECT name, colour, height, smell
FROM flowers
</CFQUERY>

-- which then you can display in a table etc., or styled with CSS, in
any way you like.

### Restrictions on remote connections

Although connecting from machines in the studio should be fine, you'll
find that you cannot connect via Samba to the IS CF server, nor to our
MySQL server, from machines outside the University domain (e.g. if you
are using a third-party ISP from home). This is because we have
firewalls for security purposes. However, you can use the University's
Virtual Private Network (VPN) --- once you are connected to the VPN,
your machine appears to be within the University domain, and everything
is OK. See <http://www.ucs.ed.ac.uk/nsd/access/vpnservice.html> for
details of how to do this. The same applies if you are connecting via
wireless, in the usual way (so if you are used to connecting using
wireless via the VPN, this should all work the same as usual).

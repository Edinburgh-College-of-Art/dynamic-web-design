---
layout: page
title: Dynamic Web Design FAQ
---

### How do I setup

[See setup instructions]()

### I can't get F3 to work

Make sure you [start from the simple example first]()

### Can use node.js, Django, Flask, bottle &c... instead of F3?

No.

### Do I have to use F3

No, but you won't get very far or much support getting there.

### How do I store Images in a Database

See the F3 Simple Image Server Example

### Can I host my site somewhere else

Yes, at your own risk and with no support.

### How do I get started?

use F3_SimpleExample as a template

### How should we work as a group?

This is something for your group to discuss, though you may want to read about our [suggested workflows]().

### What can I do with PHP / JavaScript

Wrong question! What would you like to do?

### My Code won't work, how do I fix it?

See [How to Debug and Ask Questions]()

### "Access to XMLHttpRequest at YOUR ADDRESS from origin 'null' has been blocked by CORS policy "

You are probably

- using `XMLHttpRequest` rather than Ajax
- Are querying a https from a http site or vice versa
- you have opened the `html` page your browser address bar should read `file://path/to/your/file`, don't do that, use your server instead.

### Internal Server Error

This error means something went wrong on the server when trying to access your site. This could be down to:

- folder or file permissions
- authentication
- invalid php code

Here are some ways to help identify each and fix them.

#### Internal Server Error: SQLSTATE

```
Internal Server Error

SQLSTATE[HY000] [1045] Access denied for user 'username'@'localhost' (using password: YES) [/home/username/AboveWebRoot/fatfree/lib/db/sql.php:548]
```

Your Database password is incorrect in `DatabaseConnection.php` reset the password and try again.

Be sure to check the file in your PHPStorm project matches the file on your Server in `AboveWebRoot/autoload/DatabaseConnection.php`.

#### The server encountered an internal error or misconfiguration

```
The server encountered an internal error or misconfiguration and was unable to complete your request.

Please contact the server administrator at webmaster@your_domain.edinburgh.domains to inform them of the time this error occurred, and the actions you performed just before this error.

More information about this error may be available in the server error log.

Additionally, a 500 Internal Server Error error was encountered while trying to use an ErrorDocument to handle the request.
```



### How do I share my data base

See [suggested workflows].

### I get a Internal Server Error

It may seem tedious, but read the error message, if it tells you a specific file name or line number, you might want to start looking there. Ask about the error and look at How to debug and Ask a question

### My site isn't updating the style / content

- Use your browser in `private` mode to stop file caching
- check the file have been uploaded to your server

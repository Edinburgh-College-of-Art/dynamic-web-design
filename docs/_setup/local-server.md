---
layout: page
title: Local Server (Optional)
course: Dynamic Web Design
order: 5
---

Some functionality of a web page works as expected when the files are placed online via FTP or SSH. However, if you try to view them locally, you see some kind of "cross-origin" errors in console. The solution to this is to view them using what's called a local web server. This tutorial includes instructions for setting up several types of local web servers on each of macOS, Windows, and Linux.

If you are using PHPStorm, a local http server will be created for you when you run the page.

If you opted for [Sublime Text Editor](https://www.sublimetext.com/), a very simple way to set up a Local Server, without having to know the Command Line interface, is to use the [Browser Sync](https://packagecontrol.io/packages/Browser%20Sync) plugin for Sublime Text 3.

***

## Web Server for Chrome extension

The simplest and fastest solution for anyone using a Chrome web browser is to install the [Web Server for Chrome](https://chrome.google.com/webstore/detail/web-server-for-chrome/ofhbbkphhbklhfoeikjpcbhemlocgigb/) extension. Visit its chrome web store page and install it.

By default, the Web Server won't run in the background, so keep it open for it to work. To launch it on [most devices](https://support.google.com/chrome_webstore/answer/3060053), type `chrome://apps` in the Chrome address bar and press [Enter] to see all your Chrome apps, then click the Web Server icon. On a [Chromebook](https://support.google.com/chromebook/answer/6206362), press the Search key (🔍) or click the Launcher icon (usually at the bottom left corner of the screen) to find and launch the Web Server.

After launching the Web Server a new window will open. There you can click [CHOOSE FOLDER] and select the folder with the HTML page for your sketch. Now you can just click on the Web Server URL (`http://127.0.0.1:8887` by default) to see and open your sketch. If you name your sketch HTML page `index.html` and enable `Automatically show index.html`, your sketch will load as soon as you open the URL!

***

## Python SimpleHTTPServer (1st option)

If you need a quick web server running and you don't want to mess with setting up apache or something similar, then Python can help. Python comes with a simple builtin HTTP server. With the help of this little HTTP server you can turn any directory in your system into your web server directory. The only thing you need to have installed is [Python](https://www.python.org/downloads/) (Python is already installed if you are using Mac OS X).

[Python SimpleHTTPServer tutorial](https://github.com/lmccart/itp-creative-js/wiki/SimpleHTTPServer)

Type in Terminal:

```
python -m SimpleHTTPServer
```

Or if you are using Python 3, type:

```
python -m http.server
```

Then visit `http://localhost:8000` on your browser.

Unfortunately the python simple server is very slow. Loading a local page will often stall and it can't stream video and has trouble with even medium size files like an 8MB mp3 for example. However, it should suffice for loading in most text files, fonts and most images.

***

## Node http-server (2nd option)

An alternative is node.js `http-server`. It is much faster than python simple server while requiring a little bit of setup. Just 3 simple steps:

1.  [Download and Install node.js](https://nodejs.org/en/download/)
2.  Open a terminal or command prompt (on Windows you might need to open the command prompt as admin)
3.  In the terminal type:

        npm install -g http-server

Done!

From then on just `cd` to the folder that has the files you want to serve and type

    http-server

Then point your browser at `http://localhost:8080/`

Note 1: If you are having problems where the browser does not reload your javascript files after changes are made, you may need to instantiate the server with a specific cache value. To do this, include the cache timeout flag, with a value of '-1'. This tells the browser not to cache files (like sketch.js).

```bash
http-server -c-1
```

Alternatively, you can setup a `browser-sync` server which has the added benefit of automatically reloading the webpage when any changes were saved in the source code.

1.  Follow instructions above to install node.js and open a Terminal/Command Prompt window
1.  Type

        npm install -g browser-sync

1.  `cd` into your project folder.
1.  Type

        browser-sync start --server -f -w

1.  Your website should be available at `http://localhost:3000` and whenever you save a file in your project, the webpage will automatically reload.

- [https://www.browsersync.io/#install](https://www.browsersync.io/#install)
- [https://github.com/CodingTrain/Rainbow-Topics/issues/646](https://github.com/CodingTrain/Rainbow-Topics/issues/646)

Note 2: If you encountered an error that says `EACCES` when installing either `http-server` or `browser-sync` it means npm is not installed with the right permissions, follow the steps outlined at https://docs.npmjs.com/getting-started/fixing-npm-permissions to fix it.

***

## Using PHP built-in web server (3rd option)

[PHP has (since version 5.4.0) a built-in web server](https://secure.php.net/manual/en/features.commandline.webserver.php)

To check if you have PHP installed you can open a terminal and issue the command:

```
php -version
```

If you have PHP CLI (Command Line Interpreter) installed you can start a local development server by using the command:

```
php -S localhost:8000
```

Then point your browser at `http://localhost:8000/`

***

## Setting up Browser Sync for Sublime Text (command line free option)

The Browser Sync plugin for Sublime Text allows you to launch your project in the browser and having the page refresh each time you save a modification to your file (<kbd>Ctrl</kbd> + <kbd>S</kbd>).

To install the plugin you will first need load the Package repository by doing this:

- Open the Command Palette by using <kbd>Ctrl</kbd> + <kbd>⇧</kbd> + <kbd>P</kbd> or going to Tools > Command Palette
- Type "Install Package" and hit <kbd>⏎</kbd>
- The repository will be loaded in a matter of seconds

Once the repository is loaded, you can search and launch the installation of the Browser Sync plugin.

- Inside the same Command Palette type `Browsersync`
- The suggest option shows you the Browser Sync plugin, click on it and hit <kbd>⏎</kbd>
- Once completed the installation of the plugin, a new menu, "Browser Sync", appears on the menu bar

Now that the Browser Sync plugin is installed on your Sublime Text Editor, here is how to use it.

- Say you have Chrome opened and in Sublime Text your project is opened as well.
- In the "Browser Sync" menu, go to "Start File" and choose your".../index.html" file
- Then, go to "Browser Sync" menu again and click "Launch"
- Now your project should open in a new Chrome Tab
- Each time you'll save (<kbd>Ctrl</kbd> + <kbd>S</kbd>) your modifications in Sublime Text, your projects Chrome Tab will refresh

---
layout: page
title: Setup PHPStorm SFTP
course: Dynamic Web Design
order: 1
---

An easy way to edit your site directly is to connect via SSH File Transfer Protocol (SFTP). This guide covers how to upload files over SFTP with PHPStorm. You can approach this 2 ways.

<!--
-   **Method 1:** create a single _main_ project that will allow you to see your entire server
-   **Method 2:** create individual project per site your are working on. -->

If you haven't already, go to [Jetbrains.com/student](https://www.jetbrains.com/community/education/#students) to sign-up for your academic licence.

Once you have signed-up, [login to JetBrains](https://account.jetbrains.com/login) and you should see your academic licences. Click `Download` underneath the licence to see the apps available. Select PHPStorm

![](img/jetbrains-download.png)

* * *

### Create A New Project

![Create A New Project GIF](gif/1-new-phpstorm-project.gif)

* * *

### Set SFTP Server

-   Go to Preferences (or Settings)

    -   <i class="fa fa-apple" aria-hidden="true"></i>: <kbd>⌘</kbd> + <kbd>,</kbd>
    -   <i class="fa fa-windows" aria-hidden="true"></i>: <kbd>Ctrl</kbd> + <kbd>Alt</kbd> + <kbd>S</kbd>

-   `Build, Execution, Deployment` -> `Deployment`
-   Click the <kbd>+</kbd> icon to add a server.
    -   Select SFTP
    -   It is a good idea to name it the same as your domain `your_domain.edinburgh.domains`

![Set SFTP Server Gif](gif/2-sftp-setup-add-webserver.gif)

-   Next to SSH Configuration, click <kbd>...</kbd>
    -   click <kbd>+</kbd>
    -   Enter these details

| Field                | SFTP                            |
| -------------------- | ------------------------------- |
| Host                 | `your_domain.edinburgh.domains` |
| port                 | `22`                            |
| User Name            | **DOMAIN_USERNAME**†            |
| Authentication type: | Password                        |
| Password             | **DOMAIN_PASSWORD**†            |

![Set SFTP Server Gif](gif/3-sftp-setup-add-ssh.gif)

* * *

**†** Your Domain Username and Password should have been provided in your sign-up email. You can change your password at [edinburgh.domains/user-information/](https://edinburgh.domains/user-information/) (sign-in required)

### Test Connection

-   Click Test Connection
    -   This should be successful. See Troubleshooting if there is an error.

### Deployment Options

Once you have successfully setup and mapped your project, there are a couple more options to configure in `Build, Execution, Deployment` -> `Deployment` -> `Options`:

-   Set `Upload changed files automatically to the default server` select `on explicit action`
-   Click `Override default permissions on files` and make sure it is set to `(644)`
-   Click `Override default permissions on folders` and make sure it is set to `(755)`

![Automatic Upload GIF](gif/5-sftp-setup-deployment-options.gif)

* * *

Your SFTP connection setup for the project is complete. The next stage is to [add the Fat Free Framework and the `FFF-SimpleExample` to your server](./FFF-SimpleExample.html).

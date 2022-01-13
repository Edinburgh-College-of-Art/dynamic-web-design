---
layout: page
title: Fat Free Framework Setup
course: Dynamic Web Design
repo_url: dynamic-web-design
order: 2
---

This is a short guide to adding the Fat Free Framework to your server. Make sure to follow [Setup PHPStorm SFTP](phpstorm-sftp-setup) first.

## Add Fat Free Framework (FFF)

1.  Go to the [FFF Website](https://fatfreeframework.com/3.6/home)
2.  [Download the latest release](https://github.com/bcosca/fatfree/archive/master.zip)
3.  In PHPStorm Create a Directory named `AboveWebRoot`
4.  Add copy the contents of `fatfree-master` folder to the `AboveWebRoot` Directory

![fatfree to AboveWebRoot](gif/6-fff-setup)

5.  Go to `Build, Execution, Deployment` -> `Deployment`,
6.  go to `Mappings` tab
7.  Click <kbd>Add New Mapping</kbd>

    -   Local Path: `AboveWebRoot` folder you just creates
    -   Deployment Path:
        -   right click the top level
        -   create a Dirctory named `AboveWebRoot` ![](img/phpstorm-new-mapping-directory.png)
    -   Web Path: `/`
    -   click Okay

8.  Right click the `AboveWebRoot` directory in your PHPStorm project and select `Deployment` -> `Upload to YOUR_DOMAIN.edinburgh.domains`
9.  Fat free should now be on you server. Check in you `edinburgh.domains` File Manager to make sure.

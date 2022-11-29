---
layout: page
title: Setup Database
course: Dynamic Web Design
repo_url: dynamic-web-design
order: 3
---

## Create a table

1.  go to your edinburgh.domains dashboard
2.  go to **phpMyAdmin**
3.  Select your database `Username_DatabaseName`
4.  click `New`
    ![](img/phpMyAdmin_new_table.png)
5.  add a new table named `simpleModel` with these columns
6.  You will need to add an additional column
    ![](img/phpMyAdmin_add_column.png)

| Name   | Type    | Length/Values | Index   | A_I |
| ------ | ------- | ------------- | ------- | --- |
| id     | BIGINT  | -             | Primary | x   |
| name   | VARCHAR | 200           | -       | -   |
| colour | VARCHAR | 200           | -       | -   |

-   you can leave other unmentioned attributes blank.
-   when you check `A_I` or `Primary` just click `Go` on the pop-up
    ![](img/phpMyAdmin_sql_fields.png)

6.  click `Save`

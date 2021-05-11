---
layout: page
title: Database Setup
course: Dynamic Web Design
repo_url: dynamic-web-design
order: 2
---

1. Go to `AboveWebRoot` `>` `autoload` `>` `DatabaseConnection.php`
2. Fill in the missing details of the file

```php
class DatabaseConnection {

	static function connect() {
		  return new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=<UUN>',
			'<UUN>',
			'PASSWORD'
		  );
	}

}
```

- Refer to the `database_info.txt` for your `PASSWORD`.
- Your <UUN> is your student number e.g. s12345678. e.g.

```php
class DatabaseConnection {

	static function connect() {
		  return new DB\SQL(
			'mysql:host=localhost;port=3306;dbname=s12345678',
			's12345678',
			'PASSWORD'
		  );
	}

}
```

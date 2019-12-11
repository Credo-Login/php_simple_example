This example demonstrates how to use PHP to authenticate users using [Credo](https://usecredo.com/). Use
this example as a starting point for your own web applications.

## Instructions

1. Make sure php and php-curl are installed. Else install them using the following command.

```bash
$ sudo apt-get install php php-curl
```

2. Clone this repository.

```bash
$ git clone https://github.com/Credo-Login/php_simple_example
```

3. In `index.php` insert your CLIENT_ID and CLIENT_SECRET on lines 4 and 5.

4. Start the PHP built in server.

```bash
$ cd php_simple_example
$ php -S 0.0.0.0:8080
```

5. Open a web browser and navigate to [http://localhost:8080/](http://localhost:8080/)
   to see the example in action.

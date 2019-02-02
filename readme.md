
# Chuck Norris Jokes Demo

The project was build using [Laravel]  5.7 Framework which is the framework of my choice and using it the past 3 years developing projects for my work. It offers great tools out of the box and also it's offering great extensibility with many libraries making a laravel version.

## Installation

The Project needs the following requirements to run :

* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* Composer Dependency Manager

Install the dependencies by issuing issuing the Composer command in your terminal in the project folder:

```sh
composer install
```

Make a copy of the .env-example file and name it .env,
then change the mail setting to your prefrence this is what ive used for my local mail server testing
```
MAIL_DRIVER=smtp
MAIL_HOST=maildev
MAIL_PORT=25
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

For the email layout ive used this simple library https://github.com/leemunroe/responsive-html-email-template
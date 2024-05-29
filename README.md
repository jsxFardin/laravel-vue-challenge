## Laravel vue (inertia) CRUD


1. Install composer packages

```
$ composer install
```

2. Install npm packages

```
$ npm i
```

3. Create and setup .env file

```
make a copy of .env.example
$ copy .env.example .env
$ php artisan key:generate
put database credentials in .env file
```

4. Migrate and insert records

```
$ php artisan migrate --seed 
```

5. Serving application
```
$ php artisan serve
$ npm run dev
```


## Installation and Configuration

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
```

## Configure MySQL (Generally to issue queries through phpMyAdmin)
Search for `[mysql]` section in `my.ini` or `my.cnf` file, and search for `sql_mode` setting under this section. (If there is no `[mysql]` section, then add it in the file; if there is no `sql_mode` setting, then add it too.) Set `sql_mode` environment variable under section `[mysql]` to blank:
```ini
sql_mode=""
```

MySQL needs to be restarted after making the above change.

#### Configure the following variable in the **`.env`** file (If not using **`.env`** then update corresponding **`config/*.php`** file(s))
```
APP_NAME=...
APP_ENV= # specify local for localhost, any other value for other server (for exmaple: demo or production)
APP_DEBUG= # true or false
APP_URL= # path to the public folder

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=pusher
MAIL_MAILER=smtp
# MAIL_DRIVER=smtp # for laravel < 7
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_NAME="${APP_NAME}"
MAIL_FROM_ADDRESS=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=

# for resource/js/app.js
# need to define below values with 'MIX_' prefix in their name
# laravel-mix sets values in file only if the config settings' names have 'MIX_' prefix
MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

MAIL_MAILER=smtp
# MAIL_DRIVER=smtp # for laravel < 7
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="${APP_NAME}"
MAIL_FROM_ADDRESS=

STRIPE_API_PUBLIC_KEY=
STRIPE_API_SECRET_KEY=
```

Execute command **`npm run dev`** *(for development build)* **OR** **`npm run prod`** *(for production build)*

If different service is used than Pusher for events broadcasting then need to update corresponding variables in **`resources/js/pusher.js`**

---

## Run
```bash
php artisan serve
```

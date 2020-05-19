## Calendarific Test

This goal of this app is to provide a month/year and country picker which will be sent to the Calenderific API to return the holidays for the given prameters and display them in a sorted table.

## Why HTTP and not the official SDK?
Typically I'd like to use the Official SDK for a service, which there was one [Calendarific](https://github.com/calendarific/php-calendarific) however for this demo we'll keep it simple and make use of Laravel's HTTP Facade.

## Integrations / Libraries Used
- Laravel 7
- Calendarific API
- Vue.js
- Inertia.js
- Buefy
- Material Design Icons

## Demo

1. Run `composer install`
2. Copy `.env.example` to `.env` if it hasn't been created already.
3. Edit the `.env` file and update the `CALENDARIFIC_API_KEY=` with your API key.
4. Run `php artisan serve`
5. Go to `http://127.0.0.1:8000`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

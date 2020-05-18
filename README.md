## Calendarific Test

This goal of this app is to provide a month and country picker that will retrieve public holidays for the selected month and country from the Calendarific API and return them the the user.

## Why HTTP and not the official SDK?
Typically I'd like to use the Official SDK for a service, in this case there was one for [Calendarific](https://github.com/calendarific/php-calendarific) for this demo we'll keep it simple and use Laravel's HTTP Facade.

## Integrations / Libraries Used
- Calendarific API
- InertiaJS
- Buefy

## Demo

1. Run `composer install`
2. Copy `.env.example` to `.env` if it hasn't been created already.
3. Edit the `.env` file and update the `CALENDARIFIC_API_KEY=` with your API key.
4. Run `php artisan serve`
5. Go to `http://127.0.0.1:8000/`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Uptime Monitor

Simple Laravel API for monitoring site uptime and storing check history.

## Requirements

- Laravel 13
- PHP 8.4+
- Composer
- MySQL or another supported Laravel database

## Project Setup

1. Clone the repository.
2. Install PHP dependencies.
3. Create and update environment config.
4. Generate app key.
5. Run migrations.
6. Start the server.

~~~bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
~~~

If you use Herd, open the Herd URL for this project instead of php artisan serve.

## API Endpoints

- GET /api/monitors
- POST /api/monitors
- GET /api/monitors/{id}/history

## Test With Postman

### 1) Create a monitor (POST)

Request:

- Method: POST
- URL: http://127.0.0.1:8000/api/monitors
- Headers:
	- Accept: application/json
	- Content-Type: application/json
- Body (raw JSON):

~~~json
{
	"url": "https://example.com",
	"check_interval": 5,
	"threshold": 3
}
~~~

Expected response:

- Status: 201
- JSON payload with created monitor in data

### 2) List monitors (GET)

- Method: GET
- URL: http://127.0.0.1:8000/api/monitors
- Header: Accept: application/json

### 3) Get monitor history (GET)

- Method: GET
- URL: http://127.0.0.1:8000/api/monitors/1/history?per_page=15
- Header: Accept: application/json

## Test With Browser Console

Open your app in the browser, press F12, then run these in Console.

### GET monitors

~~~javascript
fetch('/api/monitors', {
	method: 'GET',
	headers: { 'Accept': 'application/json' }
})
.then(async r => ({ status: r.status, body: await r.json() }))
.then(console.log)
.catch(console.error);
~~~

### POST monitor

~~~javascript
fetch('/api/monitors', {
	method: 'POST',
	headers: {
		'Accept': 'application/json',
		'Content-Type': 'application/json'
	},
	body: JSON.stringify({
		url: 'https://example.com',
		check_interval: 5,
		threshold: 3
	})
})
.then(async r => ({ status: r.status, body: await r.json() }))
.then(console.log)
.catch(console.error);
~~~

If your app is not on the same host/port, use full URLs like http://127.0.0.1:8000/api/monitors in fetch.

## Optional Queue and Scheduler

If you are dispatching monitor jobs and using scheduled checks:

~~~bash
php artisan queue:work
php artisan schedule:work
~~~

## Common Troubleshooting

- Composer curl error 6 / Could not resolve host:
	- Check DNS and internet access.
	- Try switching DNS servers and run ipconfig /flushdns.
- 422 validation errors on POST /api/monitors:
	- Confirm url is valid and unique.
	- Confirm check_interval is between 1 and 60.
	- Confirm threshold is at least 1.

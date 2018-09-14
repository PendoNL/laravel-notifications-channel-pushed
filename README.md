# Pushed.co notification channel for Laravel 5.3+

This package makes it easy to send notifications using [Pushed](http://pushed.co) with Laravel 5.3+.

## Contents

- [Installation](#installation)
    - [Setting up the Pushed service](#setting-up-the-pushed-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

To get the latest version of Pushed Notification channel for Laravel 5.3, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require pendonl/laravel-notifications-channel-pushed
```

Or you can manually update your require block and run `composer update` if you choose so:

```json
{
    "require": {
        "pendonl/laravel-notifications-channel-pushed": "^1.0"
    }
}
```

You will also need to install `guzzlehttp/guzzle` http client to send request to Pushed API.

If you use Laravel 5.5 or higher, you don't need the following step. If not, once package is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `PendoNL\LaravelNotificationsChannelPushed\PushedServiceProvider::class`

### Setting up the Pushed service

Login to [Pushed](#installation), create a new app or edit an existing one. Navigate to `App Settings` and find the App Key and App Secret around the bottom of the page. You need to put it to `config/services.php` configuration file. You may copy the example configuration below to get started:

```php
'pushed' => [
    'app_key' => env('PUSHED_APP_KEY', ''),
    'app_secret' => env('PUSHED_APP_SECRET', '')
]
```

Put these Environment keys in the .env file of your project

```
PUSHED_APP_KEY=
PUSHED_APP_SECRET=
```

## Usage

First of, create or edit a Notification of your choice. In order to send notifications using this channel you have to specify a `toPushed` method on your Notification.

### The `toPushed` Method

```php
/**
 * Get the Pushed representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \PendoNL\LaravelNotificationsChannelPushed\PushedMessage
 */
public function toPushed($notifiable)
{
    $url = url('/thanks');
    
    return PushedMessage::create('Thank you for using our application!')
        ->setUrl($url)
        ->toApp();
}
```

#### Available Message methods
- `setUrl($url)`: (string) adds a URL action to the notification
- `toApp()`: sends the notification to all users registered to your app
- `toChannel($alias)`: (string) sends the notification to a given channel alias
- `toUser($accessToken)`: (string) sends the notification to a user that registered to your app using OAuth
- `toPushedId($pushedId)`: (string) sends the notification directly to a user's Pushed ID

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email joshua@pendo.nl instead of using the issue tracker.

## Contributing

Please feel free to Fork this project and make improvements. Create a Pull request with sufficient information about what improvements or changes you've made.

## Credits

- [Pushed.co](https://pushed.co/)
- [laravel-notification-channels](https://github.com/laravel-notification-channels)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

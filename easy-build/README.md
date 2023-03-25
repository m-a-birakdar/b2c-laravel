# Easy-Build

## Introduction
Introducing easy-build, the package that makes building your fresh laravel project easier than ever before. With easy-build, you can quickly set up a solid foundation for your new project without having to worry about the nitty-gritty details of configuration and setup.

This package is designed to streamline the process of building a new project, saving you valuable time and effort. With just a few simple commands, you can have your project up and running in no time.

Say goodbye to the headache of manually setting up your project and hello to easy-build. Try it out today and see how much easier building your fresh project can be!

With easy-build, you can enjoy the benefits of adminlte admin dashboard and many beautiful auth pages without the hassle of manual setup. Try it out today and see how much easier building your fresh project can be!

## Dependencies

Easy-build depends on the following packages:

- `nwidart/laravel-modules` (Created by [nwidart](https://github.com/nWidart))
- `theanik/laravel-more-command` (Created by [theanik](https://github.com/theanik))

Additionally, easy-build uses [Adminlte](https://adminlte.io/) admin dashboard with many beautiful auth pages.

| **PHP / Laravel** | **Easy-Build** |
|-------------------|----------------|
| 8.0.2 / 9.0       | ^1.0           |
| 8.1 / 10.0        | ^2.0           |

**Note** : You can use all artisan command about previous packages.

## Install

To install package:

``` bash
composer require birakdar/easy-build
```

``` bash
php artisan easy-build:install
```

The `Birakdar\EasyBuild\EasyBuildServiceProvider` is auto-discovered and registered by default.



Now you can generate many modules:

``` bash
php artisan easy-build:generate User Category Product
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
Easy-build depends on the following packages:


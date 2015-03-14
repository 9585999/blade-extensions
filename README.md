![Laravel logo](http://laravel.com/assets/img/laravel-logo.png)  Laravel Blade Extensions
========================

[![Build Status](https://img.shields.io/travis/RobinRadic/blade-extensions.svg?branch=master&style=flat-square)](https://travis-ci.org/RobinRadic/blade-extensions)
[![GitHub Version](https://img.shields.io/github/tag/robinradic/blade-extensions.svg?style=flat-square&label=version)](http://badge.fury.io/gh/robinradic%2Fblade-extensions)
[![Code Coverage](https://img.shields.io/badge/coverage-100%-green.svg?style=flat-square)](http://robin.radic.nl/blade-extensions/coverage)
[![Total Downloads](https://img.shields.io/packagist/dt/radic/blade-extensions.svg?style=flat-square)](https://packagist.org/packages/radic/blade-extensions)
[![License](http://img.shields.io/badge/license-MIT-ff69b4.svg?style=flat-square)](http://radic.mit-license.org)

[![Goto Documentation](http://img.shields.io/badge/goto-docs-orange.svg?style=flat-square)](http://docs.radic.nl/blade-extensions)
[![Goto API Documentation](https://img.shields.io/badge/goto-api--docs-orange.svg?style=flat-square)](http://radic.nl:8080/job/blade-extensions/PHPDOX_Documentation/)
[![Goto Repository](http://img.shields.io/badge/goto-repo-orange.svg?style=flat-square)](https://github.com/robinradic/blade-extensions)


Version 2.1
-----------

**Laravel 5** package providing additional Blade functionality. [**Thoroughly**](http://docs.radic.nl/blade-extensions/) documented and **100%** code coverage.

- **@set @unset** Setting and unsetting of values
- **@foreach @break @continue** Loop data and extras
- **@partial @block @render** Creating view partials and blocks. Nest them, extend them, render them.
- **@debug @breakpoint** Dump values and set breakpoints in views
- **@macro** Defining and running macros (optional, requires [illuminate/html](https://github.com/erusev/parsedown))
- **@markdown** Render github flavoured markdown with your preffered renderer by using the directives or view engine/compilers. (optional, requires [erusev/parsedown](https://github.com/erusev/parsedown) or [kzykhys/ciconia](https://github.com/kzykhys/Ciconia))
- **BladeViewTestingTrait** enables all assert methods from your test class in your view as directives. `@assertTrue($hasIt)..`
  

#### Installation  
###### Requirements
```JSON
"PHP": ">=5.4.0",
"illuminate/support": "~5.0"
```
  
###### Recommended
```JSON
"illuminate/html": "~5.0",
"raveren/kint": ">=0.9.1",
"erusev/parsedown": "~1.5"
```
  
  
###### Composer
```JSON
"radic/blade-extensions": "2.*"
```
###### Laravel
```php
'Radic\BladeExtensions\BladeExtensionsServiceProvider'
```


#### Some examples

[**Check the documentation for all features and options**](http://docs.radic.nl/blade-extensions/)

```php
@foreach($stuff as $key => $val)
    $loop->index;       // int, zero based
    $loop->index1;      // int, starts at 1
    $loop->revindex;    // int
    $loop->revindex1;   // int
    $loop->first;       // bool
    $loop->last;        // bool
    $loop->even;        // bool
    $loop->odd;         // bool
    $loop->length;      // int

    @foreach($other as $name => $age)
        $loop->parent->odd;
        @foreach($friends as $foo => $bar)
            $loop->parent->index;
            $loop->parent->parentLoop->index;
        @endforeach
    @endforeach
    
    
    @section('content')
        @partial('partials.danger-panel')
            @block('title', 'This is the panel title')
    
            @block('body')
                This is the panel body.
            @endblock
        @endpartial
    @stop
    
    @partial('partials.panel')
        @block('type', 'danger')
    
        @block('title')
            Danger! @render('title')
        @endblock
    @endpartial
    
    @break

    @continue
@endforeach

@set('newvar', 'value')
{{ $newvar }}


@debug($somearr)
```

### Copyright/License
Copyright 2014 [Robin Radic](https://github.com/RobinRadic) - [MIT Licensed](http://radic.mit-license.org)

[![Build Status](https://travis-ci.org/shopping24/css-beautifier.svg?branch=develop)](https://travis-ci.org/shopping24/css-beautifier)
# CSSBeautifier

## What is the CSSBeautifier?

The CSSBeautifier make your uglified CSS great again!

## Requirements:

- You need at least PHP 5.6.0

## Installation:

```
    composer require shopping24/css-beautifier
```

## Usage

```php
    <?php
    
    use Shopping24\CSSBeautifier;
    
    class Foo
    {
        public function doSomething()
        {
            $uglyCSS = "foo{foo:bar;}";
            
            $beautyCSS = CSSBeautifier::run($uglyCSS);        
        }
    }
```
# PHBlazer 

`PHBlazer` is an easy hackable static site generator designed to be intuitive
from the very beginning. We utilize the whole featureset of `handlebars` and
`markdown` for the site generation. This reduces syntax sugar and prevents
reading hours of documentation to get started. We designed it to be assessable
and also provide site examples to accelerate your site development.

## Documentation

The best to way to get started is to check out the `content`, `template` and
`public` folder. 

## Installation 

Requirements:
- php8
- composer
- inotify-tools (optional)
- make (optional)

To install the dependencies run:
```console
cd src/
composer install
```

## Usage

```console
php src/index.php
``` 

We also provide a `Makefile` for building and developing your site. 

## Contribution

Feel free to open a PR to contribute to this project.

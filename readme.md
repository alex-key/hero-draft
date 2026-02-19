<p align="center">
  <img src="public/img/logo.svg" width="200" alt="Logo">
</p>

# Hero Draft 

![WIP](https://img.shields.io/badge/status-work--in--progress-yellow)

A simple web application to generate superhero cards using image generation AI tools and manual tuning. Currently supports only **Stability AI** (check [v2beta Docs](https://platform.stability.ai/docs/api-reference))


## Technical stack

- **Laravel 12** with **InertiaJS**
- **Vue 3** with Composition API
- **shadcn** components library
- **Tailwind CSS**
- AI REST APIs: **StabilityAI** (planned to add more)
- **SQLite** database

## Installation

Install PHP and JavaScript dependencies
```bash
 composer run setup

```

Add StabilityAI API key to `.env`
```bash
# Stability AI API
STABILITY_API_KEY={YOUR_API_KEY}

```

## Development

Run project

```bash
 composer run dev

```


## Screenshots

![mainpage.jpg](public/img/screenshots/mainpage.jpg)

![finish-hero.jpg](public/img/screenshots/finish-hero.jpg)

![login.jpg](public/img/screenshots/login.jpg)

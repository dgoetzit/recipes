# Recipe Search 3000

The Recipe Search 3000 application is the best way to find and save recipes that you and your loved ones will enjoy for the rest of your lives. It provides an intuitive and easy to use interface that will make finding recipes just as enjoyable as consuming them. No more reading through several pages of content before you see what you came here to see - the ingredients you need, and how to put it all together.

## Table of Contents
- [Introduction](#introduction)
- [Prerequisites](#prerequisites)
- [Installation Guide](#installation-guide)
- [Getting Started](#getting-started)
- [Features](#features)
- [Future Development](#future-development)

## Introduction

Recipe Search 3000 combines a Laravel backend with a Nuxt.js frontend to deliver a seamless recipe search experience. Whether you're looking for dinner inspiration or wanting to save your favorite recipes, our application has you covered with a clean, straightforward interface that prioritizes what matters most.

**Tech Stack:**
- Backend: Laravel
- Frontend: Nuxt.js / Vue
- Environment: Docker & Docker Compose

## Prerequisites

Before diving into Recipe Search 3000, make sure you have:

- Docker
- Docker Compose
- Git

## Installation Guide

Follow these steps to get Recipe Search 3000 up and running:

### 1. Clone the Repository

```bash
git clone git@github.com:dgoetzit/recipes.git
cd recipes
```

> Just want to browse the code? Check out this pull request: https://github.com/dgoetzit/recipes/pull/1

### 2. Install Laravel Dependencies

```bash
docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    bash -c "composer install"
```

### 3. Configure and Start the Application

Create your environment configuration:
```bash
cp .env.example .env
```

Start the Docker containers:
```bash
./vendor/bin/sail up -d
```

Generate an application key:
```bash
./vendor/bin/sail artisan key:generate
```

Set up the database with sample data:
```bash
./vendor/bin/sail artisan migrate:fresh --seed
```

> **Quick Check:** At this point, your backend should be running. You can verify by visiting http://localhost:8888 in your browser.

### 4. Set Up the Frontend

Install NPM dependencies:
```bash
./vendor/bin/sail npm install --prefix frontend
```

Start the frontend development server:
```bash
./vendor/bin/sail npm run dev --prefix frontend
```

### 5. Access the Application

You're all set! Visit Recipe Search 3000 at:
**http://localhost:3000**

## Getting Started

When you first open Recipe Search 3000, you'll find a clean interface focused on helping you find recipes quickly:

1. **Try the search:** Look for a specific ingredient like "chicken" or search for a type of dish like "pasta"
2. **Explore recipe details:** Click on any recipe to see ingredients and step-by-step instructions
3. **Save favorites:** Use the "Save" button to keep track of recipes you love

## Features

### Search Options
The application provides two powerful ways to search:

- **Index Page Search:** Find recipes by author, keyword, or ingredient
- **Global Search:** Quick keyword search available from anywhere in the app

The index search lets you be specific about what you're looking for, while the global search offers convenience when you need it.

### Saved Recipes
Never lose track of your favorite recipes again! The application uses Vue's Pinia store to maintain your collection of saved recipes:

- Click "Save" on any recipe page
- Access all your favorites from the "Saved Recipes" menu
- Your saved recipes are persisted in local storage, so they will still be there even if you stop/re-start the application

### Recommended Recipes
Recipe Search 3000 provides recommended recipes on each recipe page by finding recipes that are similar in terms of both the name of the dish, as well as the ingredients that it uses.

### SEO
SEO was a consideration for this project:

- Server-side rendering improves discovery by search engines
- Each page contains appropriate metadata based on its content

## Future Development

While Recipe Search 3000 already offers a solid user experience, there are several areas for enhancement that would elevate the application further. Here's a detailed roadmap of potential improvements:

### Testing

I included a couple of very minimal component tests, but I would have loved to implement end-to-end browser tests to ensure everything in the application works as expected across any environment.

**Specific Opportunities:**
- **End-to-End Testing with Cypress/Playwright**: Implement comprehensive test suites for critical user flows (search → view recipe → save recipe)
- **Component Testing**: Expand Vue Test coverage for complex components like the recipe cards and search functionality
- **State Testing**: Create dedicated tests for edge cases including empty states, error handling, and loading scenarios


### Code Quality

While I did include Prettier and ESlint in the project, the rules within could certainly be expanded upon, and it would be great to have a CI/CD setup that enforces code quality and code formatting rules.

**Specific Opportunities:**
- **Custom ESLint Rules**: Add project-specific rules enforcing consistent component structure and naming conventions
- **GitHub Actions Workflow**: Create automated checks that run linting, formatting, and tests on every PR

### Optimization

There are a lot of areas in the application that can be optimized, both from a written code perspective, and a performance perspective. The frontend contains some repeated patterns that could be further extracted to ensure consistency.

**Specific Opportunities:**
- **Component and Function Abstraction**: Extract repeated UI elements as well as similar functionality into dedicated components, composables, or utilities.

In terms of performance, images were not a requirement of this project, but they would be one of the first things that I'd like to improve upon for easy performance gains. Utilizing a CDN as the Nuxt Image provider would offer significant advantages over having the images live within the project itself.

**Image Optimization Specifics:**
- **Nuxt Image Module Integration**: Implement with a CDN provider like Cloudinary or Imgix
- **Responsive Images**: Generate multiple sizes for different viewport widths
- **CSS Optimization**: Implement PurgeCSS to reduce unused Tailwind classes in production

### User Experience Enhancements

Based on the application's current state, several UX improvements could further elevate the experience:

- **Search Filtering & Sorting**: Add the ability to filter by dietary restrictions, cooking time, and difficulty
- **Personalized Recommendations**: Implement a simple recommendation engine based on saved recipes
- **Recipe Collections**: Allow users to organize saved recipes into custom collections (weeknight meals, holiday dishes, etc.)
- **Social Sharing**: Add ability to share recipes via social media or email
- **Print-Friendly Formatting**: Create a dedicated print layout for recipes
- **Measurement Conversion**: Add toggling between metric and imperial units
- **Serving Size Adjustment**: Allow users to scale recipes up or down based on needed servings

### Backend Improvements

While focusing primarily on the frontend, several backend enhancements would support a better overall application:

- **API Caching**: Implement Redis for frequently accessed recipe data
- **Rate Limiting**: Add protection against excessive API requests
- **Authentication System**: Build out proper user accounts with profile management
- **Advanced Search**: Implement Elasticsearch for better search relevance and typo tolerance

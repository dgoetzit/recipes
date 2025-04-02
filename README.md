# Recipe Search 3000
The Recipe Search 3000 application is the best way to find and save recipes that you and your loved ones will enjoy for the rest of your lives. It provides an intuitive and easy to use interface that will make finding recipes just as enjoyable as consuming them. No more reading through several pages of content before you see what you came here to see - the ingredients you need, and how to put it all together.

## Local Setup
To set the application up locally, please ensure you have both of the following installed on your machine:
- docker
- docker-compose

### Clone the following repository
`git clone git@github.com:dgoetzit/recipes.git`

`cd recipes`

### Install composer dependencies for the Laravel application

```bash
docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    bash -c "composer install"
```

### Run the application
`cp .env.example .env`

`./vendor/bin/sail up -d`

`./vendor/bin/sail artisan key:generate`

`./vendor/bin/sail artisan migrate:fresh --seed`

### Install node dependencies and launch the frontend
`./vendor/bin/sail npm install --prefix frontend`

`./vendor/bin/sail npm run dev --prefix frontend`

### Check out the application
Once you've done all of the above, you should be able to view the application here: http://localhost:3000

## Features and Functionality
The following section highlights some of the features and functionality of the application, so you can easily dig in.

### Search
The application provides two core mechanisms for searching:
- Through the index page
- Global search

The index page provides 3 input fields in order to provide the best possible results depending on exactly what you are looking for, while the global search provides a single input field.

From the index search, you can search for an author, a keyword, or an ingredient. The global search simply searches on keyword, since it is the broadest of the search categories.

### Saved Recipes
The application provides a Vue store mechanism via Pinia to save recipes that you like, making it easier to find them the next time around. Simply click the "Save" button from the view page of a recipe, and it will be included in your "Saved Recipes" menu item.

### Recommended Recipes
When viewing a recipe, you will be provided with two mechanisms to see recommended and/or related recipes. Each listed ingredient provides you with a search icon - which upon clicking opens a modal containing other recipes that use this same ingredient. You can also choose to "See all", which will bring you back to the search index page and scope your search to the recipe you were looking for.

At the bottom of the view recipe page, you can also see related recipes by name. If not enough similarly named recipes exist, the process will fallback to relating by ingredients.

### SEO
SEO considerations have been made for this application. The application is server side rendered, and each page contains the appropriate SEO metadata based on its content.

## What's Next
There were quite a lot of things that I would have done on this project granted more time. In no particular order, those items would have been as follows.

### Testing
I included some very minimal component tests, but I would have loved to implement end-to-end browser tests to ensure everything in the application works as expected across every environment. This also would have allowed for testing against various states, like empty and error, very easily.

Further down the line I would have liked to extend

### Code Quality
While I did include Prettier and ESlint in the project, the rules within could certainly be expanded upon, and it would be great to have a CI/CD setup that enforces code quality and code formatting rules.

### Optimization
There are a lot of areas in the application that can be optimized, both from a written code perspective, and a performance perspective. The frontend contains a decent number of repeated patterns that could be further extracted to ensure consistency.

In terms of performance, images were not a requirement of this project, but they would be one of the first things that I'd like to improve upon for easy performance gains. Utilizing a CDN as the Nuxt Image provider would offer significant advantages over having the images live within the project itself.

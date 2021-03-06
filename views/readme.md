## Getting started

[![Watch the getting started video](https://res.cloudinary.com/evanagee/image/upload/c_scale,w_1000/v1580251167/VueWP/getting-started-youtube2.jpg)](https://www.youtube.com/watch?v=xF-ZVrk7N5g)

1. **Clone the repo** inside of your `wp-content/themes/` directory
2. **Navigate to the theme directory in your terminal** and run
   `npm install`
   `npm run watch` for development
   `npm run build` when you're ready to deploy the theme.
3. **Activate the theme** in your WordPress instance.
4. **Update your permalink settings** `(Settings -> Permalinks)` to be **"Day and name"**. If you don't want to use this setting you'll need to update the Vue router so it can find your content correctly. Please note that if you want to use a different permalink structure you'll need to update `./src/router/index.js` so it looks for the correct path.
5. Boom.com!

Since by default Tailwind completely resets all styles/spacing, there are a few initial styles I've provided in `src/assets/css/_tailwind.css` to make things appear more like you'd expect. Modify to your liking!

## Code Organization

All of the code you're going to edit is located in `/src/`. From there it's broken into a few logical directories.

- `/src`
  - `/api` for API requests
  - `/assets` for images mostly
  - `/components` Vue components
  - `/router` vue-router directives
  - `/store` vuex store and modules
  - `/assets/css` CSS styles
  - `/vendor` 3rd party scripts and libraries

All scripts and styles in `/src` are compiled down to the `/dist` directory, which is what you will deploy. **When you're ready to deploy don't deploy the src/ directory.**

## New to Vue?

Not sure where to begin? The [Vuejs documentation](https://vuejs.org/v2/guide/) is actually amazing, but if you're looking for video training I highly recommend the free [Learn Vue 2: Step By Step](https://laracasts.com/series/learn-vue-2-step-by-step) course over at Laracasts. There's also a [great playlist by Academind](https://www.youtube.com/watch?v=FXY1UyQfSFw&list=PL55RiY5tL51qxUbODJG9cgrsVd7ZHbPrt) available on YouTube that covers pretty much everything you'd want to know about building a fully-featured Vue app.

I've created a couple of example components in `src/components/widgets` to give you an idea of how to work with the Vuex store data.

If you're new to Vue/Vuex I would do the following:

- Open up `src/app.js` this is the main JS file for the app and will give you a glimpse into what's going on behind the scenes.
- Next open up `src/App.vue` this is the primary app component, a page wrapper of sorts. It contains the header/footer and the `<router-view>` component which is what loads in all of the other screens as you navigate around the app. Note that by default `src/components/Home.vue` is loaded into the `router-view` initially.
- Next open up `src/routes/index.js` and notice how the routes are setup by default. Out of the box there is only one route, the `/` or home view. For more information on setting up routing within your app checkout [Vue-Router](https://router.vuejs.org/).
- Next is the Vuex store. I won't cover how that works here as it's a tiny bit more advanced. Check out all files in `src/store` and start to familiarize yourself with what's going on. It's based on the official Vuex example project setup and uses Vuex modules. By default I've included a couple of modules I thought you might need.

The first thing you're probably going to want to do is start editing and components in `src/components/`.

## External References

- [Creating Vuex Modules](https://vuex.vuejs.org/en/modules.html)
- [vue-router](https://github.com/vuejs/vue-router)
- [WordPress REST API](http://v2.wp-api.org/)
- [WordPress REST API Handbook](https://developer.wordpress.org/rest-api/)
- [Expose ACF fields to REST API](https://github.com/airesvsg/acf-to-rest-api/)

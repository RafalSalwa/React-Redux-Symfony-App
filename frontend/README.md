# Getting Started with Create React App

This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

## Available Scripts

In the project directory, you can run:

### `npm start`

Runs the app in the development mode.\
Open [http://localhost:3000](http://localhost:3000) to view it in your browser.


### `npm run build`

Builds the app for production to the `build` folder.\
It correctly bundles React in production mode and optimizes the build for the best performance.

## Decisions
- httpsOnly cookies authentication flow (skipped localstorage for this)
- Separate layouts for Authenticated and unathenticated users with support of React-Router-Domv6
- ReactFormHooks and ypu validator for fields
- Authenticated user data (from api) is stored "as it is" from backend since user entity can change
- 
- [Sneat](https://themewagon.com/themes/free-responsive-bootstrap-5-html5-admin-template-sneat/) bootstrap template 
- One api call in app bootstrap at App.js to fetch user and hold it's state in redux
- 

## further plans
- move dev env from npm start to docker container
- cleanup in forms for registration and login, maybe to MUI 
- add React Query to handle api calls
- add Jest tests or any tests
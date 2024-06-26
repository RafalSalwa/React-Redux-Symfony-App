import React from 'react';
import { Provider } from 'react-redux';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import store from './store/store';
import ErrorBoundary from "./Components/ErrorBoundary";

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    <Provider store={store}>
        <ErrorBoundary>
            <App />
        </ErrorBoundary>
    </Provider>
);
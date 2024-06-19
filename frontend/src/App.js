import './App.css';
import React, { useEffect } from 'react';
import { BrowserRouter as Router, Route, Routes, Navigate } from 'react-router-dom';
import { useSelector, useDispatch, } from 'react-redux';
import { fetchUserAction } from './features/authSlice';
import Footer from "./Components/Footer";
import Registration from "./Pages/Registration/Registration";
import PrivateRoute from './Components/PrivateRoute';
import Login from "./Pages/Login/Login";
import Profile from "./Pages/Profile/Profile";
import ErrorBoundary from "./Components/ErrorBoundary";
import AuthLayout from './Layout/AuthLayout';
import UserLayout from './Layout/UserLayout';

const App = () => {
    const dispatch = useDispatch();
    const { loading, authUser } = useSelector((state) => state.auth);

    useEffect(() => {
        dispatch(fetchUserAction());
    }, [dispatch]);

    if (loading) return;

    return (
        <Router>
            <ErrorBoundary>
                    <div className="App">
                        <main>
                            <Routes>
                                <Route element={<AuthLayout />}>
                                    <Route path="/" element={authUser ? <Navigate to="/profile" /> : <Login />} />
                                    <Route path="/register" element={authUser ? <Navigate to="/profile" /> : <Registration />} />
                                    <Route path="/login" element={authUser ? <Navigate to="/profile" /> : <Login />} />
                                </Route>
                                <Route element={<UserLayout />}>
                                <Route
                                    path="/profile"
                                    element={
                                        <PrivateRoute>
                                            <Profile />
                                        </PrivateRoute>
                                    } />
                                    </Route>
                            </Routes>
                        </main>
                        <Footer />
                    </div>
            </ErrorBoundary>
        </Router>
    );
}

export default App;

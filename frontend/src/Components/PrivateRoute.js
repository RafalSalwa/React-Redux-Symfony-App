import React from 'react';
import { Navigate } from 'react-router-dom';
import { useSelector } from 'react-redux';

const PrivateRoute = ({ children }) => {
  const authUser = useSelector((state) => state.auth.authUser);

  return authUser ? children : <Navigate to="/login" />;
};

export default PrivateRoute;
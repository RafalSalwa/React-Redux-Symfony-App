import React from 'react';
import { Navigate } from 'react-router-dom';
import { useSelector } from 'react-redux';

const UnAuthenticatedRoute = ({ children }) => {
  const authUser = useSelector((state) => state.auth.authUser);

  return authUser ?<Navigate to="/login" /> :  children;
};

export default UnAuthenticatedRoute;
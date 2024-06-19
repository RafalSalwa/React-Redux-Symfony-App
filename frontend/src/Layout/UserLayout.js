import React from 'react';
import { Link, Outlet, useNavigate } from 'react-router-dom';
import { useSelector, useDispatch } from 'react-redux';
import { logoutUserAction } from '../features/authSlice';
import CdnUtils from '../Utils/Cdn'

const UserLayout = () => {
  const { loading, authUser } = useSelector((state) => state.auth);
  const dispatch = useDispatch();
  const navigate = useNavigate();

  const handleLogout = () => {
    dispatch(logoutUserAction());
    navigate('/login');
  };
  if (loading) return <div>Loading...</div>;

  return (
    <div className="layout-wrapper layout-content-navbar  ">
      <div className='layout-container'>
        <div className="layout-page">
          <nav className="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <ul className="navbar-nav">
              {authUser ? (
                <>
                  <li className="nav-item">
                    <Link className="nav-link" to="/profile">Profile</Link>
                  </li>
                  <li className="nav-item">
                    <button className="nav-link btn btn-link" onClick={handleLogout}>Logout</button>
                  </li>
                </>
              ) : (
                <>
                  <li className="nav-item">
                    <Link className="nav-link" to="/register">Register</Link>
                  </li>
                  <li className="nav-item">
                    <Link className="nav-link" to="/login">Login</Link>
                  </li>
                </>
              )}
            </ul>
            <div className="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div className="navbar-nav align-items-center">
                <div className="nav-item d-flex align-items-center">
                  <i className="bx bx-search fs-4 lh-0"></i>
                </div>
              </div>
              <ul className="navbar-nav flex-row align-items-center ms-auto">
                <li className="nav-item lh-1 me-3">
                  {authUser && <span> {authUser.fullName || `${authUser.firstName} ${authUser.lastName}`}</span>}
                </li>
                <li className="nav-item navbar-dropdown dropdown-user dropdown">
                    <div className="avatar avatar-online">
                    {authUser &&<img src={CdnUtils.getPhotoUrl(authUser.avatar)} alt="" className="w-px-40 h-auto rounded-circle" />}
                    </div>
                </li>
              </ul>
            </div>
          </nav>
          <div className="content-wrapper">
            <div className="container-fluid flex-grow-1 container-p-y">
              <div className="layout-demo-wrapper">
                <Outlet />
              </div>
            </div>
            <div className="content-backdrop fade"></div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default UserLayout;
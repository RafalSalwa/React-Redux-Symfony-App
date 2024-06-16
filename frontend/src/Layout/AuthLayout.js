import React from 'react';
import { Outlet } from 'react-router-dom';
import '../assets/vendor/css/pages/page-auth.css'
import '../assets/vendor/css/core.css'
import '../assets/vendor/css/theme-default.css'

const AuthLayout = () => {
    return (
        <div className="container-xxl">
            <div className="authentication-wrapper authentication-basic container-p-y">
                <div className="authentication-inner">
                    <div className="card">
                        <div className="card-body m-3">
                            <Outlet />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default AuthLayout;
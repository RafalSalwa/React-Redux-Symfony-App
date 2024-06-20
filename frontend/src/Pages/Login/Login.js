import React, {useState} from 'react';
import { useForm } from 'react-hook-form';
import { Link, useNavigate } from "react-router-dom";
import { yupResolver } from '@hookform/resolvers/yup';
import { useDispatch, useSelector } from "react-redux";
import * as yup from 'yup';
import { loginUser } from '../../services/api';
import { StatusCodes } from 'http-status-codes'
import { loginSuccess, fetchUserAction } from '../../features/authSlice';

const schema = yup.object().shape({
    email: yup.string().email('Invalid email').required('Email is required'),
    password: yup.string().min(6).max(50).required('Password is required'),
});

const Login = () => {
    const navigate = useNavigate();
    const dispatch = useDispatch();
    const [error, setError] = useState(null);

    const {
        register,
        handleSubmit,
        formState: { errors }
    } = useForm({
        resolver: yupResolver(schema),
    });

    const onSubmit = async data => {
        try {
            const response = await loginUser(data);
            if (response.status === StatusCodes.OK) {
                dispatch(loginSuccess());
                dispatch(fetchUserAction());

                navigate('/');
            }
        } catch (error) {
            setError(error.response.data.message);
            console.error("login catch err:", error);
        }
    };

    return (
        <>
        <h4 className="mb-2">Adventure starts here 🚀</h4>
            <p className="mb-4">Please sign-in to your account and start the adventure</p>
                <form onSubmit={handleSubmit(onSubmit)}>
                    <div className="mb-3">
                        <label htmlFor="email" className="form-label">Email</label>
                        <input id="email" {...register('email')} className="form-control"/>
                        {errors.email && <span className="text-danger">{errors.email.message}</span>}
                    </div>
                    <div className="mb-3">
                        <label htmlFor="password" className="form-label">Password</label>
                        <input type="password" id="password" {...register('password')} className="form-control" />
                        {errors.password && <span className="text-danger">{errors.password.message}</span>}
                    </div>
                    <button type="submit" className="btn btn-primary d-grid w-100">Login</button>
                </form>
                {error && <div className="alert alert-danger mt-3">{error}</div>}
                <p className="text-center mt-3">
                <span>New on our platform? </span>
                <Link to="/register"><span>Create an account</span></Link>
            </p>
            </>
    );
}

export default Login;
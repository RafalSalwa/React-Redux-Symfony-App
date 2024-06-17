import React, {useState} from 'react';
import {useForm} from 'react-hook-form';
import {Link, useNavigate} from "react-router-dom";
import {yupResolver} from '@hookform/resolvers/yup';
import * as yup from 'yup';
import {registerUser} from '../../services/api';
import {StatusCodes} from 'http-status-codes'

const schema = yup.object().shape({
    firstName: yup.string().min(2).max(25).required('First Name is required'),
    lastName: yup.string().min(2).max(25).required('Last Name is required'),
    email: yup.string().email('Invalid email').required('Email is required'),
    password: yup.string().min(6).max(50).matches(/\d/, 'Password must contain at least one number').required('Password is required'),
    photos: yup.mixed().test('required', 'At least 4 photos are required', (value) => {
        if (!value) return true;
        return value.length === 0 || value.length >= 4;
    }),
});

function Registration() {
    const navigate = useNavigate();
    const [filePreviews, setFilePreviews] = useState([]);
    const [fileNames, setFileNames] = useState([]);

    const {
        register,
        handleSubmit,
        formState: {errors},
        setValue
    } = useForm({
        resolver: yupResolver(schema),
    });

    const handleFileChange = (e) => {
        const files = Array.from(e.target.files);
        const previews = [];
        const names = [];

        files.forEach(file => {
            const reader = new FileReader();

            reader.onload = (event) => {
                previews.push(event.target.result);
                setFilePreviews([...previews]);
            };

            reader.readAsDataURL(file);
            names.push(file.name);
        });
        setFileNames(names);
        setValue('photos', e.target.files);
    };

    const handleClearFiles = () => {
        setValue('photos', []);
        setFilePreviews([]);
        setFileNames([]);
    };

    const onSubmit = async data => {
        console.log("onSubmit", data)
        try {
            const response = await registerUser(data);
            if (response.status === StatusCodes.CREATED) {
                navigate('/login');
            }
        } catch (error) {
            console.error("register error", error);
        }
    };

    return (
        <>
            <h4 className="mb-2">Adventure starts here 🕸️</h4>
            <p className="mb-4">Please sign-in to your account and start the adventure</p>
            <form onSubmit={handleSubmit(onSubmit)}>
                <div className="mb-3">
                    <label htmlFor="firstName" className="form-label">First Name</label>
                    <input id="firstName" {...register('firstName')} className="form-control"/>
                    {errors.firstName && <span className="text-danger">{errors.firstName.message}</span>}
                </div>
                <div className="mb-3">
                    <label htmlFor="lastName" className="form-label">Last Name</label>
                    <input id="lastName" {...register('lastName')} className="form-control"/>
                    {errors.lastName && <span className="text-danger">{errors.lastName.message}</span>}
                </div>
                <div className="mb-3">
                    <label htmlFor="email" className="form-label">Email</label>
                    <input id="email" {...register('email')} className="form-control"/>
                    {errors.email && <span className="text-danger">{errors.email.message}</span>}
                </div>
                <div className="mb-3">
                    <label htmlFor="password" className="form-label">Password</label>
                    <input type="password" id="password" {...register('password')} className="form-control"/>
                    {errors.password && <span className="text-danger">{errors.password.message}</span>}
                </div>
                <div className="mb-3">
                    <label htmlFor="photos" className="form-label">Photos</label>
                    <input
                        type="file"
                        id="photos"
                        {...register('photos')}
                        // onChange={handleFileChange}
                        multiple
                        className="form-control"
                    />

                    {errors.photos && <span className="text-danger">{errors.photos.message}</span>}
                    <div>
                        <p>File Previews:</p>
                        <div style={{display: 'flex', flexWrap: 'wrap'}}>
                            {filePreviews.map((preview, index) => (
                                <div key={index} style={{margin: '10px', textAlign: 'center'}}>
                                    <img key={index} src={preview} alt={`Preview ${index}`}
                                         style={{width: '100px', height: 'auto', margin: '5px'}}/>
                                    <p>{fileNames[index]}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                    {fileNames.length > 0 && (
                        <button type="button" className="btn btn-sm btn-danger mt-2" onClick={handleClearFiles}>Clear
                            Files</button>
                    )}
                </div>
                <button type="submit" className="btn btn-primary d-grid w-100"
                        onClick={handleSubmit(onSubmit)}>Register
                </button>
            </form>
            <p className="text-center mt-3">
                <span>Already have an account? </span>
                <Link to="/login"><span>Sign in instead</span></Link>
            </p>
        </>
    );
}

export default Registration;
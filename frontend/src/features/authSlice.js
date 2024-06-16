import { createSlice } from '@reduxjs/toolkit';
import { getCurrentUser, logoutCurrentUser } from "../Services/UserService";

const authSlice = createSlice({
    name: 'auth',
    initialState: {
        isAuthenticated: false,
        authUser: null,
        loading: false,
        error: null,
    },
    reducers: {
        fetchUserStart(state) {
            state.loading = true;
            state.error = null;
        },
        fetchUserSuccess(state, action) {
            state.loading = false;
            state.authUser = action.payload;
        },
        fetchUserFailure(state, action) {
            state.loading = false;
            state.error = action.payload;
        },
        loginSuccess(state, action) {
            state.isAuthenticated = true;
            state.authUser = action.payload;
        },
        logoutSuccess(state) {
            state.isAuthenticated = false;
            state.authUser = null;
        },
    },
});

export const { fetchUserStart, fetchUserSuccess, fetchUserFailure, loginSuccess, logoutSuccess } = authSlice.actions;

export const fetchUserAction = () => async (dispatch) => {
    dispatch(fetchUserStart());
    try {
        const response = await getCurrentUser();
        const user = response.data
        dispatch(fetchUserSuccess(user));
    } catch (error) {
        dispatch(fetchUserFailure(error.message));
    }
};

export const logoutUserAction = () => async (dispatch) => {
    try {
        await logoutCurrentUser();
        dispatch(logoutSuccess());
    } catch (error) {
        dispatch(fetchUserFailure(error.message));
    }
    
};

export default authSlice.reducer;
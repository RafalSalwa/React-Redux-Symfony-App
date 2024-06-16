import { combineReducers } from 'redux';
import authReducer from '../features/authSlice'
const reducer = combineReducers({
    auth: authReducer,
});

export default reducer;